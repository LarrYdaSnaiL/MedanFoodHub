PGDMP      3            	    |            MedanFoodHub    16.4    16.4                0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false                       0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false                       0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false                       1262    24603    MedanFoodHub    DATABASE     �   CREATE DATABASE "MedanFoodHub" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_Indonesia.1252';
    DROP DATABASE "MedanFoodHub";
                postgres    false            �            1259    24692    restaurant_menu    TABLE     �   CREATE TABLE public.restaurant_menu (
    rest_id integer,
    picture character varying(255),
    name character varying(255)
);
 #   DROP TABLE public.restaurant_menu;
       public         heap    postgres    false            �            1259    24684    restaurants    TABLE     �   CREATE TABLE public.restaurants (
    rest_id integer NOT NULL,
    picture character varying(255),
    name character varying(255),
    location character varying(255),
    rating double precision,
    operational character varying(255)
);
    DROP TABLE public.restaurants;
       public         heap    postgres    false            �            1259    24683    restaurants_rest_id_seq    SEQUENCE     �   CREATE SEQUENCE public.restaurants_rest_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.restaurants_rest_id_seq;
       public          postgres    false    218                       0    0    restaurants_rest_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.restaurants_rest_id_seq OWNED BY public.restaurants.rest_id;
          public          postgres    false    217            �            1259    24698    reviews    TABLE     �   CREATE TABLE public.reviews (
    rev_id integer NOT NULL,
    rest_id integer,
    uid character varying(255),
    message text,
    rating double precision
);
    DROP TABLE public.reviews;
       public         heap    postgres    false            �            1259    24697    reviews_rev_id_seq    SEQUENCE     �   CREATE SEQUENCE public.reviews_rev_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.reviews_rev_id_seq;
       public          postgres    false    221                       0    0    reviews_rev_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.reviews_rev_id_seq OWNED BY public.reviews.rev_id;
          public          postgres    false    220            �            1259    24678 	   user_data    TABLE     �   CREATE TABLE public.user_data (
    uid character varying(255),
    full_name character varying(255),
    phone character varying(13)
);
    DROP TABLE public.user_data;
       public         heap    postgres    false            �            1259    24671    users    TABLE     �   CREATE TABLE public.users (
    uid character varying(255) NOT NULL,
    email character varying(255),
    usename character varying(25),
    password character varying(255)
);
    DROP TABLE public.users;
       public         heap    postgres    false            a           2604    24687    restaurants rest_id    DEFAULT     z   ALTER TABLE ONLY public.restaurants ALTER COLUMN rest_id SET DEFAULT nextval('public.restaurants_rest_id_seq'::regclass);
 B   ALTER TABLE public.restaurants ALTER COLUMN rest_id DROP DEFAULT;
       public          postgres    false    217    218    218            b           2604    24701    reviews rev_id    DEFAULT     p   ALTER TABLE ONLY public.reviews ALTER COLUMN rev_id SET DEFAULT nextval('public.reviews_rev_id_seq'::regclass);
 =   ALTER TABLE public.reviews ALTER COLUMN rev_id DROP DEFAULT;
       public          postgres    false    221    220    221            �          0    24692    restaurant_menu 
   TABLE DATA           A   COPY public.restaurant_menu (rest_id, picture, name) FROM stdin;
    public          postgres    false    219   l       �          0    24684    restaurants 
   TABLE DATA           \   COPY public.restaurants (rest_id, picture, name, location, rating, operational) FROM stdin;
    public          postgres    false    218   �       �          0    24698    reviews 
   TABLE DATA           H   COPY public.reviews (rev_id, rest_id, uid, message, rating) FROM stdin;
    public          postgres    false    221   �       �          0    24678 	   user_data 
   TABLE DATA           :   COPY public.user_data (uid, full_name, phone) FROM stdin;
    public          postgres    false    216   �       �          0    24671    users 
   TABLE DATA           >   COPY public.users (uid, email, usename, password) FROM stdin;
    public          postgres    false    215   �                  0    0    restaurants_rest_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.restaurants_rest_id_seq', 1, false);
          public          postgres    false    217                       0    0    reviews_rev_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.reviews_rev_id_seq', 1, false);
          public          postgres    false    220            f           2606    24691    restaurants restaurants_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.restaurants
    ADD CONSTRAINT restaurants_pkey PRIMARY KEY (rest_id);
 F   ALTER TABLE ONLY public.restaurants DROP CONSTRAINT restaurants_pkey;
       public            postgres    false    218            h           2606    24705    reviews reviews_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_pkey PRIMARY KEY (rev_id);
 >   ALTER TABLE ONLY public.reviews DROP CONSTRAINT reviews_pkey;
       public            postgres    false    221            d           2606    24677    users users_pkey 
   CONSTRAINT     O   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (uid);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public            postgres    false    215            �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �   �   x�M�1
�0F��>L�-ٖ�� ]dE.����޿!S�-��d��Z���&���HJo��������\콟�)����g���F���3�6t*�ʅ�Ɯl&����=(Ӥ.Z�T2����!M�x_b��1r     