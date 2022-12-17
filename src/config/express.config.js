import express from "express";
import cors from "cors";
import helmet from "helmet";
import compression from "compression";

const app = express();

app.use(compression());
//app.use(helmet());
app.use(cors({origin:'*'}));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

export default app;