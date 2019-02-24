DROP FUNCTION IF EXISTS DistaniaEuclideana;
CREATE OR REPLACE FUNCTION DistaniaEuclideana(vector1 REAL[], vector2 REAL[]) RETURNS REAL AS $$
DECLARE
  acumuladorDeDiferencias REAL;
  dimensionDelVector1 INTEGER;
  dimensionDelVector2 INTEGER;
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

DROP FUNCTION IF EXISTS PokemonVectorCaracteristico;
CREATE OR REPLACE FUNCTION PokemonVectorCaracteristico(p pokemon) RETURNS REAL[] AS $$
BEGIN
  RETURN ARRAY[
	p.c1,p.c2,p.c3,p.c4,p.c5,p.c6,p.c7,p.c8,p.c9,p.c10,
	p.c11,p.c12,p.c13,p.c14,p.c15,p.c16,p.c17,p.c18,p.c19,p.c20,
	p.c21,p.c22,p.c23,p.c24,p.c25,p.c26,p.c27,p.c28,p.c29,p.c30,
	p.c31,p.c32,p.c33,p.c34,p.c35,p.c36,p.c37,p.c38,p.c39,p.c40
  ];
END;
$$ LANGUAGE plpgsql;

DROP FUNCTION IF EXISTS ObtenerPokemonPorId;
CREATE OR REPLACE FUNCTION ObtenerPokemonPorId(idPokemon integer)
RETURNS TABLE (p pokemon) AS $$
BEGIN  
        RETURN QUERY select *   from pokemon   where id =idPokemon;
END;
$$ LANGUAGE plpgsql;

DROP FUNCTION IF EXISTS ObtenerNPokemonsSimilares;
CREATE OR REPLACE FUNCTION ObtenerNPokemonsSimilares(
	cantidadPokemons INTEGER,
	pokemonId INTEGER
)
RETURNS TABLE(id INTEGER, distancia REAL)
AS $$
DECLARE
pokemonBusquedaVectorCaracteristico REAL[];
BEGIN	
	pokemonBusquedaVectorCaracteristico := PokemonVectorCaracteristico(ObtenerPokemonPorId(pokemonId));
	RETURN QUERY SELECT p.id, distaniaEuclideana(PokemonBusquedaVectorCaracteristico,PokemonVectorCaracteristico(p)) as distancia FROM pokemon as p ORDER BY distancia ASC LIMIT cantidadPokemons;
END;
$$
LANGUAGE 'plpgsql';

--select DistaniaEuclideana(ARRAY[1,1,4],ARRAY[2,1,3]);
--select DistaniaEuclideana(PokemonVectorCaracteristico(p),PokemonVectorCaracteristico(p)) FROm pokemon as p LIMIT 1;
--select ObtenerPokemonPorId(15);
--select ObtenerNPokemonsSimilares(10,5);