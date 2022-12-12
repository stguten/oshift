import { Router } from "express";
import { home } from "../controller/bus.controller.js";

const bus = Router();

bus.get('/', home);
    
export default bus;