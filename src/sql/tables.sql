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