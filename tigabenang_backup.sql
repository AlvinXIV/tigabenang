--
-- PostgreSQL database dump
--

\restrict lYwCdUGoXtBWQjGk6G2S91g07VFPPxGeSOAKvJUwUu2iRu1x4bgQTaBnYq7S2Vi

-- Dumped from database version 16.15
-- Dumped by pg_dump version 16.15

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: bahan; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.bahan (
    id_bahan bigint NOT NULL,
    nama_bahan character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: bahan_id_bahan_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.bahan_id_bahan_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: bahan_id_bahan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.bahan_id_bahan_seq OWNED BY public.bahan.id_bahan;


--
-- Name: cache; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration bigint NOT NULL
);


--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration bigint NOT NULL
);


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection character varying(255) NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


--
-- Name: jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: kategori; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.kategori (
    id_kategori bigint NOT NULL,
    nama_kategori character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: kategori_id_kategori_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.kategori_id_kategori_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: kategori_id_kategori_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.kategori_id_kategori_seq OWNED BY public.kategori.id_kategori;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: pemesanan; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.pemesanan (
    id_pemesanan bigint NOT NULL,
    nama character varying(255) NOT NULL,
    alamat text NOT NULL,
    no_hp character varying(255) NOT NULL,
    produk_id bigint NOT NULL,
    total_harga numeric(15,2),
    upload_design character varying(255),
    notes text,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


--
-- Name: pemesanan_id_pemesanan_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.pemesanan_id_pemesanan_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: pemesanan_id_pemesanan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.pemesanan_id_pemesanan_seq OWNED BY public.pemesanan.id_pemesanan;


--
-- Name: pemesanan_material; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.pemesanan_material (
    id_pemesanan_material bigint NOT NULL,
    pemesanan_id bigint NOT NULL,
    bahan_id bigint NOT NULL
);


--
-- Name: pemesanan_material_id_pemesanan_material_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.pemesanan_material_id_pemesanan_material_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: pemesanan_material_id_pemesanan_material_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.pemesanan_material_id_pemesanan_material_seq OWNED BY public.pemesanan_material.id_pemesanan_material;


--
-- Name: pemesanan_ukuran; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.pemesanan_ukuran (
    id_pemesanan_ukuran bigint NOT NULL,
    pemesanan_id bigint NOT NULL,
    ukuran_id bigint NOT NULL,
    kuantitas integer NOT NULL
);


--
-- Name: pemesanan_ukuran_id_pemesanan_ukuran_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.pemesanan_ukuran_id_pemesanan_ukuran_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: pemesanan_ukuran_id_pemesanan_ukuran_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.pemesanan_ukuran_id_pemesanan_ukuran_seq OWNED BY public.pemesanan_ukuran.id_pemesanan_ukuran;


--
-- Name: produk; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.produk (
    id_produk bigint NOT NULL,
    kategori_id bigint NOT NULL,
    nama_produk character varying(255) NOT NULL,
    harga numeric(15,2) NOT NULL,
    gambar character varying(255),
    file_model_3d character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: produk_bahan; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.produk_bahan (
    id_produk_bahan bigint NOT NULL,
    produk_id bigint NOT NULL,
    bahan_id bigint NOT NULL
);


--
-- Name: produk_bahan_id_produk_bahan_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.produk_bahan_id_produk_bahan_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: produk_bahan_id_produk_bahan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.produk_bahan_id_produk_bahan_seq OWNED BY public.produk_bahan.id_produk_bahan;


--
-- Name: produk_id_produk_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.produk_id_produk_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: produk_id_produk_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.produk_id_produk_seq OWNED BY public.produk.id_produk;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


--
-- Name: ukuran; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.ukuran (
    id_ukuran bigint NOT NULL,
    kategori_id bigint NOT NULL,
    nama_ukuran character varying(255) NOT NULL,
    lebar_dada numeric(5,2),
    panjang numeric(5,2),
    lebar_bahu numeric(5,2),
    panjang_lengan numeric(5,2)
);


--
-- Name: ukuran_id_ukuran_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.ukuran_id_ukuran_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ukuran_id_ukuran_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.ukuran_id_ukuran_seq OWNED BY public.ukuran.id_ukuran;


--
-- Name: users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.users (
    id_user bigint NOT NULL,
    nama character varying(255) NOT NULL,
    username character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: users_id_user_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.users_id_user_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: users_id_user_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.users_id_user_seq OWNED BY public.users.id_user;


--
-- Name: bahan id_bahan; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.bahan ALTER COLUMN id_bahan SET DEFAULT nextval('public.bahan_id_bahan_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: kategori id_kategori; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.kategori ALTER COLUMN id_kategori SET DEFAULT nextval('public.kategori_id_kategori_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: pemesanan id_pemesanan; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pemesanan ALTER COLUMN id_pemesanan SET DEFAULT nextval('public.pemesanan_id_pemesanan_seq'::regclass);


--
-- Name: pemesanan_material id_pemesanan_material; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pemesanan_material ALTER COLUMN id_pemesanan_material SET DEFAULT nextval('public.pemesanan_material_id_pemesanan_material_seq'::regclass);


--
-- Name: pemesanan_ukuran id_pemesanan_ukuran; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pemesanan_ukuran ALTER COLUMN id_pemesanan_ukuran SET DEFAULT nextval('public.pemesanan_ukuran_id_pemesanan_ukuran_seq'::regclass);


--
-- Name: produk id_produk; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.produk ALTER COLUMN id_produk SET DEFAULT nextval('public.produk_id_produk_seq'::regclass);


--
-- Name: produk_bahan id_produk_bahan; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.produk_bahan ALTER COLUMN id_produk_bahan SET DEFAULT nextval('public.produk_bahan_id_produk_bahan_seq'::regclass);


--
-- Name: ukuran id_ukuran; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.ukuran ALTER COLUMN id_ukuran SET DEFAULT nextval('public.ukuran_id_ukuran_seq'::regclass);


--
-- Name: users id_user; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users ALTER COLUMN id_user SET DEFAULT nextval('public.users_id_user_seq'::regclass);


--
-- Data for Name: bahan; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.bahan (id_bahan, nama_bahan, created_at, updated_at) FROM stdin;
1	Fleece	2026-09-05 16:09:32	2026-09-05 16:09:32
2	Baby Terry	2026-09-05 16:09:32	2026-09-05 16:09:32
3	Drill	2026-09-05 16:09:32	2026-09-05 16:09:32
4	Taslan	2026-09-05 16:09:32	2026-09-05 16:09:32
5	Dry Fit	2026-09-05 16:09:32	2026-09-05 16:09:32
6	Cotton Combed	2026-09-05 16:09:32	2026-09-05 16:09:32
\.


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.cache (key, value, expiration) FROM stdin;
laravel-cache-customer.catalog.kategori.rows	a:5:{i:0;a:2:{s:11:"id_kategori";i:1;s:13:"nama_kategori";s:13:"Jaket Varsity";}i:1;a:2:{s:11:"id_kategori";i:3;s:13:"nama_kategori";s:16:"JaketWindbreaker";}i:2;a:2:{s:11:"id_kategori";i:4;s:13:"nama_kategori";s:6:"Jersey";}i:3;a:2:{s:11:"id_kategori";i:5;s:13:"nama_kategori";s:4:"Kaos";}i:4;a:2:{s:11:"id_kategori";i:2;s:13:"nama_kategori";s:11:"Work Jacket";}}	1788640307
laravel-cache-customer.catalog.has_3d	b:0;	1788625627
laravel-cache-customer.catalog.ukuran.rows	a:25:{i:0;a:7:{s:9:"id_ukuran";i:1;s:11:"kategori_id";i:1;s:11:"nama_ukuran";s:1:"S";s:10:"lebar_dada";s:5:"52.00";s:7:"panjang";s:5:"66.00";s:10:"lebar_bahu";s:5:"44.00";s:14:"panjang_lengan";s:5:"60.00";}i:1;a:7:{s:9:"id_ukuran";i:2;s:11:"kategori_id";i:1;s:11:"nama_ukuran";s:1:"M";s:10:"lebar_dada";s:5:"55.00";s:7:"panjang";s:5:"68.00";s:10:"lebar_bahu";s:5:"46.00";s:14:"panjang_lengan";s:5:"61.00";}i:2;a:7:{s:9:"id_ukuran";i:3;s:11:"kategori_id";i:1;s:11:"nama_ukuran";s:1:"L";s:10:"lebar_dada";s:5:"58.00";s:7:"panjang";s:5:"70.00";s:10:"lebar_bahu";s:5:"48.00";s:14:"panjang_lengan";s:5:"62.00";}i:3;a:7:{s:9:"id_ukuran";i:4;s:11:"kategori_id";i:1;s:11:"nama_ukuran";s:2:"XL";s:10:"lebar_dada";s:5:"61.00";s:7:"panjang";s:5:"72.00";s:10:"lebar_bahu";s:5:"50.00";s:14:"panjang_lengan";s:5:"63.00";}i:4;a:7:{s:9:"id_ukuran";i:5;s:11:"kategori_id";i:1;s:11:"nama_ukuran";s:3:"2XL";s:10:"lebar_dada";s:5:"64.00";s:7:"panjang";s:5:"74.00";s:10:"lebar_bahu";s:5:"52.00";s:14:"panjang_lengan";s:5:"64.00";}i:5;a:7:{s:9:"id_ukuran";i:6;s:11:"kategori_id";i:2;s:11:"nama_ukuran";s:1:"S";s:10:"lebar_dada";s:5:"54.00";s:7:"panjang";s:5:"67.00";s:10:"lebar_bahu";s:5:"45.00";s:14:"panjang_lengan";s:5:"59.00";}i:6;a:7:{s:9:"id_ukuran";i:7;s:11:"kategori_id";i:2;s:11:"nama_ukuran";s:1:"M";s:10:"lebar_dada";s:5:"57.00";s:7:"panjang";s:5:"69.00";s:10:"lebar_bahu";s:5:"47.00";s:14:"panjang_lengan";s:5:"60.00";}i:7;a:7:{s:9:"id_ukuran";i:8;s:11:"kategori_id";i:2;s:11:"nama_ukuran";s:1:"L";s:10:"lebar_dada";s:5:"60.00";s:7:"panjang";s:5:"71.00";s:10:"lebar_bahu";s:5:"49.00";s:14:"panjang_lengan";s:5:"61.00";}i:8;a:7:{s:9:"id_ukuran";i:9;s:11:"kategori_id";i:2;s:11:"nama_ukuran";s:2:"XL";s:10:"lebar_dada";s:5:"63.00";s:7:"panjang";s:5:"73.00";s:10:"lebar_bahu";s:5:"51.00";s:14:"panjang_lengan";s:5:"62.00";}i:9;a:7:{s:9:"id_ukuran";i:10;s:11:"kategori_id";i:2;s:11:"nama_ukuran";s:3:"2XL";s:10:"lebar_dada";s:5:"66.00";s:7:"panjang";s:5:"75.00";s:10:"lebar_bahu";s:5:"53.00";s:14:"panjang_lengan";s:5:"63.00";}i:10;a:7:{s:9:"id_ukuran";i:11;s:11:"kategori_id";i:3;s:11:"nama_ukuran";s:1:"S";s:10:"lebar_dada";s:5:"53.00";s:7:"panjang";s:5:"67.00";s:10:"lebar_bahu";s:5:"44.00";s:14:"panjang_lengan";s:5:"61.00";}i:11;a:7:{s:9:"id_ukuran";i:12;s:11:"kategori_id";i:3;s:11:"nama_ukuran";s:1:"M";s:10:"lebar_dada";s:5:"56.00";s:7:"panjang";s:5:"69.00";s:10:"lebar_bahu";s:5:"46.00";s:14:"panjang_lengan";s:5:"62.00";}i:12;a:7:{s:9:"id_ukuran";i:13;s:11:"kategori_id";i:3;s:11:"nama_ukuran";s:1:"L";s:10:"lebar_dada";s:5:"59.00";s:7:"panjang";s:5:"71.00";s:10:"lebar_bahu";s:5:"48.00";s:14:"panjang_lengan";s:5:"63.00";}i:13;a:7:{s:9:"id_ukuran";i:14;s:11:"kategori_id";i:3;s:11:"nama_ukuran";s:2:"XL";s:10:"lebar_dada";s:5:"62.00";s:7:"panjang";s:5:"73.00";s:10:"lebar_bahu";s:5:"50.00";s:14:"panjang_lengan";s:5:"64.00";}i:14;a:7:{s:9:"id_ukuran";i:15;s:11:"kategori_id";i:3;s:11:"nama_ukuran";s:3:"2XL";s:10:"lebar_dada";s:5:"65.00";s:7:"panjang";s:5:"75.00";s:10:"lebar_bahu";s:5:"52.00";s:14:"panjang_lengan";s:5:"65.00";}i:15;a:7:{s:9:"id_ukuran";i:16;s:11:"kategori_id";i:4;s:11:"nama_ukuran";s:1:"S";s:10:"lebar_dada";s:5:"50.00";s:7:"panjang";s:5:"68.00";s:10:"lebar_bahu";s:5:"43.00";s:14:"panjang_lengan";s:5:"21.00";}i:16;a:7:{s:9:"id_ukuran";i:17;s:11:"kategori_id";i:4;s:11:"nama_ukuran";s:1:"M";s:10:"lebar_dada";s:5:"53.00";s:7:"panjang";s:5:"70.00";s:10:"lebar_bahu";s:5:"45.00";s:14:"panjang_lengan";s:5:"22.00";}i:17;a:7:{s:9:"id_ukuran";i:18;s:11:"kategori_id";i:4;s:11:"nama_ukuran";s:1:"L";s:10:"lebar_dada";s:5:"56.00";s:7:"panjang";s:5:"72.00";s:10:"lebar_bahu";s:5:"47.00";s:14:"panjang_lengan";s:5:"23.00";}i:18;a:7:{s:9:"id_ukuran";i:19;s:11:"kategori_id";i:4;s:11:"nama_ukuran";s:2:"XL";s:10:"lebar_dada";s:5:"59.00";s:7:"panjang";s:5:"74.00";s:10:"lebar_bahu";s:5:"49.00";s:14:"panjang_lengan";s:5:"24.00";}i:19;a:7:{s:9:"id_ukuran";i:20;s:11:"kategori_id";i:4;s:11:"nama_ukuran";s:3:"2XL";s:10:"lebar_dada";s:5:"62.00";s:7:"panjang";s:5:"76.00";s:10:"lebar_bahu";s:5:"51.00";s:14:"panjang_lengan";s:5:"25.00";}i:20;a:7:{s:9:"id_ukuran";i:21;s:11:"kategori_id";i:5;s:11:"nama_ukuran";s:1:"S";s:10:"lebar_dada";s:5:"48.00";s:7:"panjang";s:5:"67.00";s:10:"lebar_bahu";s:5:"42.00";s:14:"panjang_lengan";s:5:"20.00";}i:21;a:7:{s:9:"id_ukuran";i:22;s:11:"kategori_id";i:5;s:11:"nama_ukuran";s:1:"M";s:10:"lebar_dada";s:5:"51.00";s:7:"panjang";s:5:"69.00";s:10:"lebar_bahu";s:5:"44.00";s:14:"panjang_lengan";s:5:"21.00";}i:22;a:7:{s:9:"id_ukuran";i:23;s:11:"kategori_id";i:5;s:11:"nama_ukuran";s:1:"L";s:10:"lebar_dada";s:5:"54.00";s:7:"panjang";s:5:"71.00";s:10:"lebar_bahu";s:5:"46.00";s:14:"panjang_lengan";s:5:"22.00";}i:23;a:7:{s:9:"id_ukuran";i:24;s:11:"kategori_id";i:5;s:11:"nama_ukuran";s:2:"XL";s:10:"lebar_dada";s:5:"57.00";s:7:"panjang";s:5:"73.00";s:10:"lebar_bahu";s:5:"48.00";s:14:"panjang_lengan";s:5:"23.00";}i:24;a:7:{s:9:"id_ukuran";i:25;s:11:"kategori_id";i:5;s:11:"nama_ukuran";s:3:"2XL";s:10:"lebar_dada";s:5:"60.00";s:7:"panjang";s:5:"75.00";s:10:"lebar_bahu";s:5:"50.00";s:14:"panjang_lengan";s:5:"24.00";}}	1788640071
laravel-cache-customer.catalog.bahan.rows	a:6:{i:0;a:2:{s:8:"id_bahan";i:2;s:10:"nama_bahan";s:10:"Baby Terry";}i:1;a:2:{s:8:"id_bahan";i:6;s:10:"nama_bahan";s:13:"Cotton Combed";}i:2;a:2:{s:8:"id_bahan";i:3;s:10:"nama_bahan";s:5:"Drill";}i:3;a:2:{s:8:"id_bahan";i:5;s:10:"nama_bahan";s:7:"Dry Fit";}i:4;a:2:{s:8:"id_bahan";i:1;s:10:"nama_bahan";s:6:"Fleece";}i:5;a:2:{s:8:"id_bahan";i:4;s:10:"nama_bahan";s:6:"Taslan";}}	1788640071
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: kategori; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.kategori (id_kategori, nama_kategori, created_at, updated_at) FROM stdin;
1	Jaket Varsity	2026-09-05 16:09:32	2026-09-05 16:09:32
2	Work Jacket	2026-09-05 16:09:32	2026-09-05 16:09:32
3	JaketWindbreaker	2026-09-05 16:09:32	2026-09-05 16:09:32
4	Jersey	2026-09-05 16:09:32	2026-09-05 16:09:32
5	Kaos	2026-09-05 16:09:32	2026-09-05 16:09:32
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.migrations (id, migration, batch) FROM stdin;
37	0001_01_01_000000_create_users_table	1
38	0001_01_01_000001_create_cache_table	1
39	0001_01_01_000002_create_jobs_table	1
40	2026_08_15_152330_create_kategori_table	1
41	2026_08_15_152421_create_bahan_table	1
42	2026_08_15_152437_create_ukuran_table	1
43	2026_08_15_152528_create_produk_table	1
44	2026_08_15_152546_create_produk_bahan_table	1
45	2026_08_15_152602_create_pemesanan_table	1
46	2026_08_15_152619_create_pemesanan_material_table	1
47	2026_08_15_152634_create_pemesanan_ukuran_table	1
48	2026_08_21_042022_create_sessions_storage_table	1
\.


--
-- Data for Name: pemesanan; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.pemesanan (id_pemesanan, nama, alamat, no_hp, produk_id, total_harga, upload_design, notes, created_at) FROM stdin;
1	Ahmad Fauzi	Jl. Asia Afrika No. 120, Bandung	081298765432	1	3500000.00	\N	Tolong sablon logo komunitas di bagian dada.	2026-09-03 16:09:32
2	Dimas Pratama	Jl. Dago No. 45, Bandung	081322334455	3	\N	\N	Warna furing hitam.	2026-09-04 16:09:32
3	Siti Nurhaliza	Jl. Ganesha No. 10, Bandung	081987654321	5	1500000.00	\N	Acara Dies Natalis	2026-09-05 16:09:32
\.


--
-- Data for Name: pemesanan_material; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.pemesanan_material (id_pemesanan_material, pemesanan_id, bahan_id) FROM stdin;
1	1	1
2	2	3
3	3	6
\.


--
-- Data for Name: pemesanan_ukuran; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.pemesanan_ukuran (id_pemesanan_ukuran, pemesanan_id, ukuran_id, kuantitas) FROM stdin;
1	1	1	5
2	1	2	5
3	2	7	10
4	3	16	10
\.


--
-- Data for Name: produk; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.produk (id_produk, kategori_id, nama_produk, harga, gambar, file_model_3d, created_at, updated_at) FROM stdin;
1	1	Heritage Varsity	350000.00	images/varsity.jpg	\N	2026-09-05 16:09:32	2026-09-05 16:09:32
2	1	Maison Varsity	375000.00	images/Varsity_Maison_Sixth_June.jpg	\N	2026-09-05 16:09:32	2026-09-05 16:09:32
4	3	Urban Windbreaker	300000.00	images/windbreaker.jpg	\N	2026-09-05 16:09:32	2026-09-05 16:09:32
5	3	Aero Shell Windbreaker	325000.00	images/windbreaker_2.jpg	\N	2026-09-05 16:09:32	2026-09-05 16:09:32
7	5	Noir Crest Tee	150000.00	images/Kaos_Champions.jpg	\N	2026-09-05 16:09:32	2026-09-05 16:09:32
8	5	Cobalt Essential Tee	140000.00	images/Kaos_Biru.jpg	\N	2026-09-05 16:09:32	2026-09-05 16:09:32
6	4	Aero Match Jersey	225000.00	images/Jersey_Minimalist.jpg	models3d/4j7sY89ULTNiLkouYpGAuVlUivGLPZildQBovu9k.glb	2026-09-05 16:09:32	2026-09-05 16:09:32
3	2	Utility Work Jacket	425000.00	images/Work_jaket.jpg	models3d/KWknGoA62aF9K7ffSOc6gkHtG9lsPiFq3NErGffj.glb	2026-09-05 16:09:32	2026-09-05 16:09:32
\.


--
-- Data for Name: produk_bahan; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.produk_bahan (id_produk_bahan, produk_id, bahan_id) FROM stdin;
1	1	1
2	2	1
3	3	3
4	4	4
5	5	4
6	6	5
7	7	6
8	8	6
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
jCEWs8WsEIhINzs1wQdYPuwJEEbUptZhEczRKgmh	\N	172.19.0.1	curl/8.21.0	eyJfdG9rZW4iOiJOeUtKb3BmQWFEMVlmQ2M4NWV4MzdVOXYzQUgyNzFSc1U3bGlXYXFTIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=	1788639584
nrXmFHhPltD98lZjJxjLTSQjICrSvxqvGP6NUdbE	\N	172.19.0.1	curl/8.21.0	eyJfdG9rZW4iOiJLSURxTEd1MjlQTG0zQmR5bHF0MUpIWVNVdFdXNDR6QU85YTlFSkc3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=	1788639584
G9VfZvh4BtlKdBw6MKzw42Fzp9qWDXNQTgMeNXR9	\N	172.19.0.1	curl/8.21.0	eyJfdG9rZW4iOiJBUmdER3d3ZU5ieHNpcFFwa0RWOGVLWmZJS1hETmZSb1VyeWhibk1BIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=	1788639580
cjdLKrC8rhCkliA278RMGNw56X9490mcyDuJ5mL9	\N	172.19.0.1	curl/8.21.0	eyJfdG9rZW4iOiJmNEcwMlpMYm5tUGdsWE9Uc0owMXIyR2Z1WG1HQVc3N21XYjNQNFVNIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=	1788639585
GmdXEmnUt6DwEXbjjGANrsQwCgjJBhBcD8qHQrWG	\N	172.19.0.1	curl/8.21.0	eyJfdG9rZW4iOiJnajNjZ2FZWW5rd2pkUVhEQ0tIY2U1dTR3akJabE9tc0dDdmVpNGRZIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=	1788639585
m1gySGTNhd8T0sHCzx6yVK0ZByKIstRWvSTtC5Ui	\N	172.19.0.1	curl/8.21.0	eyJfdG9rZW4iOiJqQnZMZlhURGgwZ0dTemJybml5UjY0aHphcnlxMDlSeTV5VUhjVkVTIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=	1788639585
HTQankmYgcbH02SY3YKixIAtOVz8jUxZJNzikRVf	\N	172.19.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36	eyJfdG9rZW4iOiJLUjdQaG45TlhXaVVHYTBpWXdXcHc0ZDZSWHpiZEhmaHlZUVk3V0VWIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=	1788639890
\.


--
-- Data for Name: ukuran; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.ukuran (id_ukuran, kategori_id, nama_ukuran, lebar_dada, panjang, lebar_bahu, panjang_lengan) FROM stdin;
1	1	S	52.00	66.00	44.00	60.00
2	1	M	55.00	68.00	46.00	61.00
3	1	L	58.00	70.00	48.00	62.00
4	1	XL	61.00	72.00	50.00	63.00
5	1	2XL	64.00	74.00	52.00	64.00
6	2	S	54.00	67.00	45.00	59.00
7	2	M	57.00	69.00	47.00	60.00
8	2	L	60.00	71.00	49.00	61.00
9	2	XL	63.00	73.00	51.00	62.00
10	2	2XL	66.00	75.00	53.00	63.00
11	3	S	53.00	67.00	44.00	61.00
12	3	M	56.00	69.00	46.00	62.00
13	3	L	59.00	71.00	48.00	63.00
14	3	XL	62.00	73.00	50.00	64.00
15	3	2XL	65.00	75.00	52.00	65.00
16	4	S	50.00	68.00	43.00	21.00
17	4	M	53.00	70.00	45.00	22.00
18	4	L	56.00	72.00	47.00	23.00
19	4	XL	59.00	74.00	49.00	24.00
20	4	2XL	62.00	76.00	51.00	25.00
21	5	S	48.00	67.00	42.00	20.00
22	5	M	51.00	69.00	44.00	21.00
23	5	L	54.00	71.00	46.00	22.00
24	5	XL	57.00	73.00	48.00	23.00
25	5	2XL	60.00	75.00	50.00	24.00
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.users (id_user, nama, username, password, created_at, updated_at) FROM stdin;
1	Admin	admin	$2y$12$HZIhx4ed6PEuNf9OWMXRm.yd6qCDsrBD3mwSBvl.HwktTujnMvMVi	2026-09-05 16:09:32	2026-09-05 16:09:32
\.


--
-- Name: bahan_id_bahan_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.bahan_id_bahan_seq', 6, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: kategori_id_kategori_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.kategori_id_kategori_seq', 5, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.migrations_id_seq', 48, true);


--
-- Name: pemesanan_id_pemesanan_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.pemesanan_id_pemesanan_seq', 3, true);


--
-- Name: pemesanan_material_id_pemesanan_material_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.pemesanan_material_id_pemesanan_material_seq', 3, true);


--
-- Name: pemesanan_ukuran_id_pemesanan_ukuran_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.pemesanan_ukuran_id_pemesanan_ukuran_seq', 4, true);


--
-- Name: produk_bahan_id_produk_bahan_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.produk_bahan_id_produk_bahan_seq', 8, true);


--
-- Name: produk_id_produk_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.produk_id_produk_seq', 8, true);


--
-- Name: ukuran_id_ukuran_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.ukuran_id_ukuran_seq', 25, true);


--
-- Name: users_id_user_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.users_id_user_seq', 1, true);


--
-- Name: bahan bahan_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.bahan
    ADD CONSTRAINT bahan_pkey PRIMARY KEY (id_bahan);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: kategori kategori_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.kategori
    ADD CONSTRAINT kategori_pkey PRIMARY KEY (id_kategori);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: pemesanan_material pemesanan_material_pemesanan_id_bahan_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pemesanan_material
    ADD CONSTRAINT pemesanan_material_pemesanan_id_bahan_id_unique UNIQUE (pemesanan_id, bahan_id);


--
-- Name: pemesanan_material pemesanan_material_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pemesanan_material
    ADD CONSTRAINT pemesanan_material_pkey PRIMARY KEY (id_pemesanan_material);


--
-- Name: pemesanan pemesanan_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pemesanan
    ADD CONSTRAINT pemesanan_pkey PRIMARY KEY (id_pemesanan);


--
-- Name: pemesanan_ukuran pemesanan_ukuran_pemesanan_id_ukuran_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pemesanan_ukuran
    ADD CONSTRAINT pemesanan_ukuran_pemesanan_id_ukuran_id_unique UNIQUE (pemesanan_id, ukuran_id);


--
-- Name: pemesanan_ukuran pemesanan_ukuran_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pemesanan_ukuran
    ADD CONSTRAINT pemesanan_ukuran_pkey PRIMARY KEY (id_pemesanan_ukuran);


--
-- Name: produk_bahan produk_bahan_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.produk_bahan
    ADD CONSTRAINT produk_bahan_pkey PRIMARY KEY (id_produk_bahan);


--
-- Name: produk_bahan produk_bahan_produk_id_bahan_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.produk_bahan
    ADD CONSTRAINT produk_bahan_produk_id_bahan_id_unique UNIQUE (produk_id, bahan_id);


--
-- Name: produk produk_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.produk
    ADD CONSTRAINT produk_pkey PRIMARY KEY (id_produk);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: ukuran ukuran_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.ukuran
    ADD CONSTRAINT ukuran_pkey PRIMARY KEY (id_ukuran);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id_user);


--
-- Name: users users_username_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_username_unique UNIQUE (username);


--
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- Name: failed_jobs_connection_queue_failed_at_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX failed_jobs_connection_queue_failed_at_index ON public.failed_jobs USING btree (connection, queue, failed_at);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: pemesanan_material pemesanan_material_bahan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pemesanan_material
    ADD CONSTRAINT pemesanan_material_bahan_id_foreign FOREIGN KEY (bahan_id) REFERENCES public.bahan(id_bahan) ON DELETE RESTRICT;


--
-- Name: pemesanan_material pemesanan_material_pemesanan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pemesanan_material
    ADD CONSTRAINT pemesanan_material_pemesanan_id_foreign FOREIGN KEY (pemesanan_id) REFERENCES public.pemesanan(id_pemesanan) ON DELETE CASCADE;


--
-- Name: pemesanan pemesanan_produk_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pemesanan
    ADD CONSTRAINT pemesanan_produk_id_foreign FOREIGN KEY (produk_id) REFERENCES public.produk(id_produk) ON DELETE RESTRICT;


--
-- Name: pemesanan_ukuran pemesanan_ukuran_pemesanan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pemesanan_ukuran
    ADD CONSTRAINT pemesanan_ukuran_pemesanan_id_foreign FOREIGN KEY (pemesanan_id) REFERENCES public.pemesanan(id_pemesanan) ON DELETE CASCADE;


--
-- Name: pemesanan_ukuran pemesanan_ukuran_ukuran_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pemesanan_ukuran
    ADD CONSTRAINT pemesanan_ukuran_ukuran_id_foreign FOREIGN KEY (ukuran_id) REFERENCES public.ukuran(id_ukuran) ON DELETE RESTRICT;


--
-- Name: produk_bahan produk_bahan_bahan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.produk_bahan
    ADD CONSTRAINT produk_bahan_bahan_id_foreign FOREIGN KEY (bahan_id) REFERENCES public.bahan(id_bahan) ON DELETE CASCADE;


--
-- Name: produk_bahan produk_bahan_produk_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.produk_bahan
    ADD CONSTRAINT produk_bahan_produk_id_foreign FOREIGN KEY (produk_id) REFERENCES public.produk(id_produk) ON DELETE CASCADE;


--
-- Name: produk produk_kategori_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.produk
    ADD CONSTRAINT produk_kategori_id_foreign FOREIGN KEY (kategori_id) REFERENCES public.kategori(id_kategori) ON DELETE RESTRICT;


--
-- Name: ukuran ukuran_kategori_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.ukuran
    ADD CONSTRAINT ukuran_kategori_id_foreign FOREIGN KEY (kategori_id) REFERENCES public.kategori(id_kategori) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

\unrestrict lYwCdUGoXtBWQjGk6G2S91g07VFPPxGeSOAKvJUwUu2iRu1x4bgQTaBnYq7S2Vi

