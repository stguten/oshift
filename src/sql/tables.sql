CREATE TABLE IF NOT EXISTS "linhas" (
	"id"	INTEGER,
	"numero"	TEXT,
	"nome"	TEXT,
	PRIMARY KEY("id")
);
CREATE TABLE IF NOT EXISTS "pontos" (
	"id"	TEXT,
	"id_numerico"	INTEGER,
	"nome"	TEXT,
	PRIMARY KEY("id")
);
CREATE TABLE IF NOT EXISTS "rotas" (
	"id_rota"	INTEGER,
	"id_linha"	INTEGER,
	"sentido"	TEXT,
	"ponto_inicial"	TEXT,
	"ponto_final"	TEXT,
	PRIMARY KEY("id_rota")
);
CREATE TABLE IF NOT EXISTS "empresas" (
	"inicio_numero"	INTEGER,
	"fim_numero"	INTEGER,
	"empresa"	TEXT,
	PRIMARY KEY("empresa")
);
INSERT OR IGNORE INTO "empresas" VALUES ('100001', '100499', 'viacao-estrela-eireli-ma');
INSERT OR IGNORE INTO "empresas" VALUES ('100500', '100999', 'ratrans');
INSERT OR IGNORE INTO "empresas" VALUES ('200001', '200999', 'rei-de-franca');
INSERT OR IGNORE INTO "empresas" VALUES ('300100', '300199', 'empresa-patrol');
INSERT OR IGNORE INTO "empresas" VALUES ('300200', '300299', 'empresa-viper');
INSERT OR IGNORE INTO "empresas" VALUES ('300400', '300499', 'expresso-rio-negro-ma');
INSERT OR IGNORE INTO "empresas" VALUES ('300500', '300599', 'speed-car');
INSERT OR IGNORE INTO "empresas" VALUES ('300600', '300699', 'autoviaria-matos');
INSERT OR IGNORE INTO "empresas" VALUES ('300700', '300799', 'planeta-transportes-sao-luis');
INSERT OR IGNORE INTO "empresas" VALUES ('300800', '300899', 'empresa-aroeiras');
INSERT OR IGNORE INTO "empresas" VALUES ('300900', '300999', 'seta-transportes-ma');
INSERT OR IGNORE INTO "empresas" VALUES ('400001', '400999', 'viacao-primor');
