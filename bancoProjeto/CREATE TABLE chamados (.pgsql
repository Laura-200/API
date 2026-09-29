CREATE TABLE chamados (
    id SERIAL PRIMARY KEY,
    equipamento VARCHAR(255) NOT NULL,
    setor VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    prioridade VARCHAR(10) NOT NULL,
    status VARCHAR(20) NOT NULL
);

SELECT * FROM chamados;
