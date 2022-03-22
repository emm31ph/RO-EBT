DELIMITER $$
DROP FUNCTION  IF EXISTS get_code;$$
CREATE FUNCTION  get_code ( 
  codedata varchar(20)
)
RETURNS text
BEGIN
  DECLARE select_var VARCHAR(255) default '';
  select content into select_var from reportitems where code=codedata;
  RETURN select_var;
END$$
DELIMITER ;


