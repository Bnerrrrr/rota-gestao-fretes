-- Cria o banco de dados do projeto (utf8mb4 aceita acentos)
CREATE DATABASE rota CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Diz ao MySQL que as próximas tabelas serão criadas dentro do banco "rota"
USE rota;

-- Tabela de produtos
-- AUTO_INCREMENT: o MySQL gera o id sozinho (1, 2, 3...)
CREATE TABLE produto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao VARCHAR(255),
    peso DECIMAL(10,2),
    valor DECIMAL(10,2)
);

-- Tabela de endereços (serve para origem e destino)
CREATE TABLE endereco (
    id INT AUTO_INCREMENT PRIMARY KEY,
    apelido VARCHAR(100) NOT NULL,
    rua VARCHAR(150),
    numero VARCHAR(10),
    bairro VARCHAR(100),
    cidade VARCHAR(100),
    estado CHAR(2),
    cep VARCHAR(9)
);

-- Tabela de transportadores
CREATE TABLE transportador (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf_cnpj VARCHAR(18),
    telefone VARCHAR(20),
    placa VARCHAR(10)
);

-- Tabela de fretes
-- Cada frete guarda os ids do transportador, da origem e do destino.
-- FOREIGN KEY garante que esses ids existem nas outras tabelas.
CREATE TABLE frete (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data DATE NOT NULL,
    id_transportador INT NOT NULL,
    id_origem INT NOT NULL,
    id_destino INT NOT NULL,
    FOREIGN KEY (id_transportador) REFERENCES transportador(id),
    FOREIGN KEY (id_origem) REFERENCES endereco(id),
    FOREIGN KEY (id_destino) REFERENCES endereco(id)
);

-- Tabela que liga o frete aos produtos.
-- Um frete pode ter VÁRIOS produtos: cada produto vira uma linha aqui.
CREATE TABLE frete_produto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_frete INT NOT NULL,
    id_produto INT NOT NULL,
    FOREIGN KEY (id_frete) REFERENCES frete(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produto) REFERENCES produto(id)
);