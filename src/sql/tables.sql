CREATE TABLE IF NOT EXISTS "linhas" (
	"id"	INTEGER,
	"numero"	TEXT,
	"nome"	TEXT
);
CREATE TABLE IF NOT EXISTS "pontos" (
	"id"	TEXT,
	"id_numerico"	INTEGER,
	"nome"	TEXT
);
CREATE TABLE IF NOT EXISTS "rotas" (
	"id_rota"	INTEGER,
	"id_linha"	INTEGER,
	"sentido"	TEXT,
	"ponto_inicial"	TEXT,
	"ponto_final"	TEXT
);
CREATE TABLE "empresas" (
	"inicio_numero"	INTEGER,
	"fim_numero"	INTEGER,
	"empresa"	TEXT
);
INSERT INTO "empresas" VALUES ('100001', '100499', 'viacao-estrela-eireli-ma');
INSERT INTO "empresas" VALUES ('100500', '100999', 'ratrans');
INSERT INTO "empresas" VALUES ('200001', '200999', 'rei-de-franca');
INSERT INTO "empresas" VALUES ('300100', '300199', 'empresa-patrol');
INSERT INTO "empresas" VALUES ('300200', '300299', 'empresa-viper');
INSERT INTO "empresas" VALUES ('300400', '300499', 'expresso-rio-negro-ma');
INSERT INTO "empresas" VALUES ('300500', '300599', 'speed-car');
INSERT INTO "empresas" VALUES ('300600', '300699', 'autoviaria-matos');
INSERT INTO "empresas" VALUES ('300700', '300799', 'planeta-transportes-sao-luis');
INSERT INTO "empresas" VALUES ('300800', '300899', 'empresa-aroeiras');
INSERT INTO "empresas" VALUES ('300900', '300999', 'seta-transportes-ma');
INSERT INTO "empresas" VALUES ('400001', '400999', 'viacao-primor');
