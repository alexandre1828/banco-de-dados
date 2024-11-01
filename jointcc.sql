SELECT 
    hd.data, 
    hd.hora, 
    hd.disponivel, 
    s.nome AS servico_nome, 
    f.nome_funcionario
FROM 
    horarios_disponiveis hd
JOIN 
    funcionarios f ON hd.funcionario_id = f.id
JOIN 
    servicos s ON hd.servico_id = s.id
WHERE 
    f.id = 3  -- Substitua ? pelo ID do funcionário desejado
    AND hd.disponivel = TRUE  -- Filtra apenas os horários disponíveis
ORDER BY 
    hd.data, hd.hora;  -- Ordena os resultados por data e hora
