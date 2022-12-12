import app from "./config/express.config.js";
import bus from "./router/bus.router.js";
import path from "path";
import * as express from 'express';

app.use('/bus', bus);
app.use('/', express.static(path.resolve() + '/public'));

export default app;