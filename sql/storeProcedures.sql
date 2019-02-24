CREATE OR REPLACE FUNCTION distaniaEuclideana(vector1 real[], vector2 real[]) RETURNS real AS $$
DECLARE
  acumuladorDeDiferencias real;
  dimensionDelVector1 int;
  dimensionDelVector2 int;
BEGIN
  acumuladorDeDiferencias := 0;
  dimensionDelVector1 = array_length(vector1,1);
  dimensionDelVector2 = array_length(vector2,1);
  
  IF (dimensionDelVector1 > 0 AND dimensionDelVector1 = dimensionDelVector2) THEN
	  FOR i IN 1..dimensionDelVector1 LOOP
		acumuladorDeDiferencias := acumuladorDeDiferencias + pow((vector1[i] - vector2[i]),2);
	  END LOOP;
	  RETURN sqrt(acumuladorDeDiferencias);
  ELSE
	  RETURN (-1);
  END IF; 
END;
$$ LANGUAGE plpgsql;

DROP FUNCTION IF EXISTS pokemonVectorCaracteristico;
CREATE OR REPLACE FUNCTION pokemonVectorCaracteristico(p pokemon) RETURNS real[] AS $$
BEGIN
  return ARRAY[
	p.c1,p.c2,p.c3,p.c4,p.c5,p.c6,p.c7,p.c8,p.c9,p.c10,
	p.c11,p.c12,p.c13,p.c14,p.c15,p.c16,p.c17,p.c18,p.c19,p.c20,
	p.c21,p.c22,p.c23,p.c24,p.c25,p.c26,p.c27,p.c28,p.c29,p.c30,
	p.c31,p.c32,p.c33,p.c34,p.c35,p.c36,p.c37,p.c38,p.c39,p.c40
  ];
END;
$$ LANGUAGE plpgsql;

select distaniaEuclideana(ARRAY[1,1,4],ARRAY[2,1])
select pokemonVectorCaracteristico(p) FROm pokemon as p LIMIT 1

DROP FUNCTION IF EXISTS ObtenerNPokemonsSimilares;
CREATE OR REPLACE FUNCTION ObtenerNPokemonsSimilares(
	cantidadPokemons INTEGER,
	
)
RETURNS TABLE(persona_id INTEGER, dependede INTEGER, nivel INTEGER)
AS $$
BEGIN
RETURN QUERY
	WITH RECURSIVE
	  elementosHastaLaRaiz(persona_id, dependede, nivel) AS 
	     (SELECT dc.persona_id, dc.dependede, 0
	       FROM docente as dc
	       WHERE
	       dc.persona_id = A
	    UNION
	       SELECT d.persona_id, d.dependede, (raiz.nivel + 1)
	       FROM elementosHastaLaRaiz as raiz, docente as d
	       WHERE  raiz.dependede IS NOT NULL AND d.persona_id = raiz.dependede)
	SELECT * FROM elementosHastaLaRaiz;
END;
$$
LANGUAGE 'plpgsql';