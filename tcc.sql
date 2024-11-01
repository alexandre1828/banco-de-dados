INSERT INTO clientes (nome_cliente, contato, email) VALUES
('João Silva', '99999-0001', 'joao.silva@email.com'),
('Maria Oliveira', '88888-0002', 'maria.oliveira@email.com'),
('Carlos Pereira', '77777-0003', 'carlos.pereira@email.com');


INSERT INTO funcionarios (nome_funcionario, cargo, contato) VALUES
('Ana Souza', 'Cabeleireira', '99999-1111'),
('Pedro Santos', 'Manicure', '88888-2222'),
('Julia Almeida', 'Esteticista', '77777-3333');

INSERT INTO servicos (nome) VALUES
('Corte de cabelo'),
('Manicure'),
('Pedicure'),
('Limpeza de pele'),
('Pintura de cabelo');

INSERT INTO horarios_disponiveis (data, hora, disponivel, servico_id, funcionario_id) VALUES
('2024-10-10', '08:00:00', TRUE, 1, 1),  -- Corte de cabelo por Ana
('2024-10-10', '09:00:00', TRUE, 2, 2),  -- Manicure por Pedro
('2024-10-10', '10:00:00', TRUE, 3, 2),  -- Pedicure por Pedro
('2024-10-10', '11:00:00', TRUE, 4, 3),  -- Limpeza de pele por Julia
('2024-10-10', '12:00:00', TRUE, 5, 1);  -- Pintura de cabelo por Ana


INSERT INTO agendamentos (cliente_id, data, horario, servico_id, status, funcionario_id) VALUES
(1, '2024-10-10', '08:00:00', 1, 'confirmado', 1),  -- João agendou Corte de cabelo com Ana
(2, '2024-10-10', '09:00:00', 2, 'pendente', 2),     -- Maria agendou Manicure com Pedro
(3, '2024-10-10', '11:00:00', 4, 'confirmado', 3);   -- Carlos agendou Limpeza de pele com Julia


