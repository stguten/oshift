import http from "../config/axios.config.js";
import database from "../config/sqlite.config.js";
import { readFileSync } from 'fs';

async function criarTabelas(){
    const sql = readFileSync('./src/sql/tables.sql','utf8') ;
    database.exec(sql);
}

async function popularDataBase(){
    try{
        await criarTabelas();
        database.run('BEGIN');
        await http.get("/forecast/lines/load/allLines/1228").then((res)=>{    
            res.data.forEach(async linha => {
                let nomeLinha = linha.name.split('-');
                database.serialize(()=>{
                    database.run('INSERT OR IGNORE INTO linhas(id,nome,numero) values ($1,$2,$3)', 
                        [linha.numero, nomeLinha.length == 1 ? linha.name.substring(linha.name.search(' ')).trimStart() : nomeLinha[1].trimStart(),linha.id]); 

                    database.run('INSERT OR IGNORE INTO rotas(id_linha,sentido,ponto_inicial, ponto_final, id_rota) values ($1,$2,$3,$4,$5)',
                        [linha.id, linha.trajetos[0].nome, linha.trajetos[0].startPoint._id, linha.trajetos[1].startPoint._id, linha.trajetos[0].id_migracao]);  

                    database.run('INSERT OR IGNORE INTO rotas(id_linha,sentido,ponto_inicial, ponto_final, id_rota) values ($1,$2,$3,$4,$5)',
                        [linha.id, linha.trajetos[1].nome, linha.trajetos[1].startPoint._id, linha.trajetos[0].startPoint._id, linha.trajetos[1].id_migracao]);               
                })
            });        
        });
        await http.get("/forecast/lines/load/allPoints/1228").then((res)=>{
            res.data.forEach(async ponto =>{
                database.run('INSERT OR IGNORE INTO pontos(id, nome, id_numerico) values ($1,$2,$3)',
                    [ponto._id, ponto.name, ponto.id]);
            })
        });
        database.run('COMMIT');
    }catch(err){
        database.run('ROLLBACK');
        throw err;
    }
}

async function consulta(){
    return new Promise((resolve,reject)=>{
        database.all(`select DISTINCT r.sentido, r.id_rota , p2.id_numerico as fim
        from rotas r
        left join linhas l on r.id_linha = r.id_linha
        left join pontos p on p.id = r.ponto_inicial
        left join pontos p2 on p2.id = r.ponto_final`,(err,rows)=>{
            if(err) reject(err);
            resolve(rows);
        });         
    });
}

async function home(req, res){
    const resultsql = await consulta();
    let finalResult = new Array();
    finalResult.push(['Veiculo','Rota','Tempo']);
    for(const element of resultsql){
        await http.get(`/forecast/lines/load/all/forecast/${element.fim}/${element.id_rota}/1228`)
        .then((linha) =>{
            if(linha.data.length > 0){
            linha.data.forEach(onibus =>{                
               finalResult.push([onibus.codVehicle,onibus.patternName, onibus.arrivalTime+' minutos']);
            });            
        }
        })
        .catch(e => console.log(e))
    };
    res.send(finalResult);
}

export {home, popularDataBase,criarTabelas};