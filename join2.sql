SELECT 
    c.nome_cliente, 
    a.data, 
    a.horario, 
    s.nome AS servico_nome, 
    f.nome_funcionario, 
    a.status
FROM 
    agendamentos a
JOIN 
    clientes c ON a.cliente_id = c.id
JOIN 
    funcionarios f ON a.funcionario_id = f.id
JOIN 
    servicos s ON a.servico_id = s.id
WHERE 
    f.id = 3 ;  -- Substitua ? pelo ID do funcionário desejado
