-- Inserir Clientes
INSERT INTO clientes (nome_cliente, contato, email) VALUES 
('João da Silva', '99999-0001', 'joao@example.com');

-- Inserir Funcionários
INSERT INTO funcionarios (nome_funcionario, cargo, contato) VALUES 
('Ana Silva', 'Cabeleireira', '99999-0002');

-- Inserir Serviços
INSERT INTO servicos (nome) VALUES 
('Corte de Cabelo');

-- Inserir Horários Disponíveis
INSERT INTO horarios_disponiveis (data, hora, disponivel, servico_id, funcionario_id) VALUES 
('2024-10-09', '15:00:00', TRUE, 1, 4);

INSERT INTO agendamentos (cliente_id, data, horario, servico_id, funcionario_id, status) VALUES 
(1, '2024-10-09', '15:00:00', 1, 4, 'confirmado');



