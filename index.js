import app from "./src/app.js";
import { criarTabelas, popularDataBase } from "./src/controller/bus.controller.js";

criarTabelas();
popularDataBase();
app.listen(3000, ()=>{
    console.log('Servidor Iniciado');
});