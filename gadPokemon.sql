PGDMP         +                w            GAD    10.4    10.4     �
           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false            �
           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false            �
           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                       false            �
           1262    19134    GAD    DATABASE     �   CREATE DATABASE "GAD" WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'Spanish_Spain.1252' LC_CTYPE = 'Spanish_Spain.1252';
    DROP DATABASE "GAD";
             postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
             postgres    false            �
           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                  postgres    false    3                        3079    12924    plpgsql 	   EXTENSION     ?   CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;
    DROP EXTENSION plpgsql;
                  false            �
           0    0    EXTENSION plpgsql    COMMENT     @   COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';
                       false    1            �            1259    19137    pokemon    TABLE     �  CREATE TABLE public.pokemon (
    "nombreArchivo" bit varying NOT NULL,
    id integer NOT NULL,
    nombre bit varying,
    c1 double precision,
    c2 double precision,
    c3 double precision,
    c4 double precision,
    c5 double precision,
    c6 double precision,
    c7 double precision,
    c8 double precision,
    c9 double precision,
    c10 double precision,
    c11 double precision,
    c12 double precision,
    c13 double precision,
    c14 double precision,
    c15 double precision,
    c16 double precision,
    c17 double precision,
    c18 double precision,
    c19 double precision,
    c20 double precision,
    c21 double precision,
    c22 double precision,
    c23 double precision,
    c24 double precision,
    c25 double precision,
    c26 double precision,
    c27 double precision,
    c28 double precision,
    c29 double precision,
    c30 double precision,
    c31 double precision,
    c32 double precision,
    c33 double precision,
    c34 double precision,
    c35 double precision,
    c36 double precision,
    c37 double precision,
    c38 double precision,
    c39 double precision,
    c40 double precision
);
    DROP TABLE public.pokemon;
       public         postgres    false    3            �            1259    19135    pokemon_id_seq    SEQUENCE     �   CREATE SEQUENCE public.pokemon_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.pokemon_id_seq;
       public       postgres    false    3    197            �
           0    0    pokemon_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.pokemon_id_seq OWNED BY public.pokemon.id;
            public       postgres    false    196            o
           2604    19140 
   pokemon id    DEFAULT     h   ALTER TABLE ONLY public.pokemon ALTER COLUMN id SET DEFAULT nextval('public.pokemon_id_seq'::regclass);
 9   ALTER TABLE public.pokemon ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    196    197    197            �
          0    19137    pokemon 
   TABLE DATA               �   COPY public.pokemon ("nombreArchivo", id, nombre, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20, c21, c22, c23, c24, c25, c26, c27, c28, c29, c30, c31, c32, c33, c34, c35, c36, c37, c38, c39, c40) FROM stdin;
    public       postgres    false    197   �       �
           0    0    pokemon_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.pokemon_id_seq', 1, false);
            public       postgres    false    196            q
           2606    19145    pokemon pokemon_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.pokemon
    ADD CONSTRAINT pokemon_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.pokemon DROP CONSTRAINT pokemon_pkey;
       public         postgres    false    197            �
      x������ � �     