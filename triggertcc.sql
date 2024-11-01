DELIMITER //

CREATE TRIGGER tornar_horario_indisponivel
AFTER INSERT ON agendamentos
FOR EACH ROW
BEGIN
    UPDATE horarios_disponiveis
    SET disponivel = FALSE
    WHERE data = NEW.data 
      AND hora = NEW.horario 
      AND servico_id = NEW.servico_id 
      AND funcionario_id = NEW.funcionario_id;
END; //

DELIMITER ;
