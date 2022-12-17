import http from "../config/axios.config.js";
import parsing from "../config/cheerio.config.js";
import database from "../config/sqlite.config.js";


async function pegarFoto(numeroOnibus){
    let numeroSemFormatacao = parseInt(numeroOnibus);
    numeroOnibus = numeroOnibus.replace(/[^0-9]/g, '').substring(0,3)+'.'+numeroOnibus.replace(/[^0-9]/g, '').substring(3,6);
    
    return new Promise((resolve, reject)=>{
        database.get(`select empresa from empresas where ? BETWEEN inicio_numero and fim_numero`,[numeroSemFormatacao], async (err,rows)=>{
            if(err) reject(new Error('Consulta Invalida'));
            console.log(rows, numeroSemFormatacao)
            //if(rows.lenght == 0) console.warn(numeroOnibus, 'não foi encontrado na database.'); 
                        
            await http.get(`https://onibusbrasil.com/empresa/${rows.empresa}/${numeroOnibus}`)
            .then((response)=>{
                const $ = parsing(response.data);
                return $('body > main > div.container.ob-thumb.p-0 > div > div:nth-child(1) > a').attr('href');
            })
            .then(async (response)=>{
                await http.get(`${response}`).then((response)=>{
                    const $ = parsing(response.data);
                    resolve("<img crossorigin=\"anonymous\" height=\"120\" width=\"120\" src=\""+$('#photo').attr('src')+"\">");
                })
            });    
        });
    })
    
}

export {pegarFoto}