--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.19
-- Dumped by pg_dump version 9.6.15

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

SET default_with_oids = false;

--
-- Name: adherent; Type: TABLE; Schema: public; Owner: svong01
--

CREATE TABLE public.adherent (
    emaila character varying(100) NOT NULL,
    noma character(30) NOT NULL,
    prenom character(30) NOT NULL,
    escaladee integer,
    joindre_sortie integer
);


ALTER TABLE public.adherent OWNER TO svong01;

--
-- Name: appartenir; Type: TABLE; Schema: public; Owner: svong01
--

CREATE TABLE public.appartenir (
    emaila character varying(100) NOT NULL,
    numcordee integer NOT NULL
);


ALTER TABLE public.appartenir OWNER TO svong01;

--
-- Name: ascension; Type: TABLE; Schema: public; Owner: svong01
--

CREATE TABLE public.ascension (
    idv integer NOT NULL,
    numcordee integer NOT NULL,
    dateascension character(10) NOT NULL,
    styleescalade character varying(21) NOT NULL
);


ALTER TABLE public.ascension OWNER TO svong01;

--
-- Name: avoir; Type: TABLE; Schema: public; Owner: svong01
--

CREATE TABLE public.avoir (
    idv integer NOT NULL,
    notefr character varying(2) NOT NULL
);


ALTER TABLE public.avoir OWNER TO svong01;

--
-- Name: contenir; Type: TABLE; Schema: public; Owner: svong01
--

CREATE TABLE public.contenir (
    idv integer NOT NULL,
    nums integer NOT NULL
);


ALTER TABLE public.contenir OWNER TO svong01;

--
-- Name: cordee; Type: TABLE; Schema: public; Owner: svong01
--

CREATE TABLE public.cordee (
    numcordee integer NOT NULL
);


ALTER TABLE public.cordee OWNER TO svong01;

--
-- Name: difficulte; Type: TABLE; Schema: public; Owner: svong01
--

CREATE TABLE public.difficulte (
    notefr character varying(2) NOT NULL,
    noteus character varying(5) NOT NULL,
    noteen character varying(4) NOT NULL
);


ALTER TABLE public.difficulte OWNER TO svong01;

--
-- Name: encadrer; Type: TABLE; Schema: public; Owner: svong01
--

CREATE TABLE public.encadrer (
    emailg character varying(100) NOT NULL,
    notefr character varying(2) NOT NULL
);


ALTER TABLE public.encadrer OWNER TO svong01;

--
-- Name: exercer; Type: TABLE; Schema: public; Owner: svong01
--

CREATE TABLE public.exercer (
    emaila character varying(100) NOT NULL,
    notefr character varying(2) NOT NULL
);


ALTER TABLE public.exercer OWNER TO svong01;

--
-- Name: guide; Type: TABLE; Schema: public; Owner: svong01
--

CREATE TABLE public.guide (
    emailg character varying(100) NOT NULL,
    nomg character varying(30) NOT NULL
);


ALTER TABLE public.guide OWNER TO svong01;

--
-- Name: localite; Type: TABLE; Schema: public; Owner: svong01
--

CREATE TABLE public.localite (
    region character varying(30) NOT NULL
);


ALTER TABLE public.localite OWNER TO svong01;

--
-- Name: pratiquer; Type: TABLE; Schema: public; Owner: svong01
--

CREATE TABLE public.pratiquer (
    emailg character varying(100) NOT NULL,
    notefr character varying(2) NOT NULL
);


ALTER TABLE public.pratiquer OWNER TO svong01;

--
-- Name: proposer; Type: TABLE; Schema: public; Owner: svong01
--

CREATE TABLE public.proposer (
    emaila character varying(100) NOT NULL,
    nums integer NOT NULL,
    description text
);


ALTER TABLE public.proposer OWNER TO svong01;

--
-- Name: sortie; Type: TABLE; Schema: public; Owner: svong01
--

CREATE TABLE public.sortie (
    nums integer NOT NULL,
    invitemax integer,
    nivmin character(5) NOT NULL,
    dates character(10) NOT NULL
);


ALTER TABLE public.sortie OWNER TO svong01;

--
-- Name: sortie_nums_seq; Type: SEQUENCE; Schema: public; Owner: svong01
--

CREATE SEQUENCE public.sortie_nums_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sortie_nums_seq OWNER TO svong01;

--
-- Name: sortie_nums_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: svong01
--

ALTER SEQUENCE public.sortie_nums_seq OWNED BY public.sortie.nums;


--
-- Name: voie; Type: TABLE; Schema: public; Owner: svong01
--

CREATE TABLE public.voie (
    idv integer NOT NULL,
    longueur character(6) NOT NULL,
    typev character varying(7) NOT NULL,
    est_situe character varying(30),
    est_suivi integer
);


ALTER TABLE public.voie OWNER TO svong01;

--
-- Name: voie_idv_seq; Type: SEQUENCE; Schema: public; Owner: svong01
--

CREATE SEQUENCE public.voie_idv_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.voie_idv_seq OWNER TO svong01;

--
-- Name: voie_idv_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: svong01
--

ALTER SEQUENCE public.voie_idv_seq OWNED BY public.voie.idv;


--
-- Name: sortie nums; Type: DEFAULT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.sortie ALTER COLUMN nums SET DEFAULT nextval('public.sortie_nums_seq'::regclass);


--
-- Name: voie idv; Type: DEFAULT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.voie ALTER COLUMN idv SET DEFAULT nextval('public.voie_idv_seq'::regclass);


--
-- Data for Name: adherent; Type: TABLE DATA; Schema: public; Owner: svong01
--



--
-- Data for Name: appartenir; Type: TABLE DATA; Schema: public; Owner: svong01
--



--
-- Data for Name: ascension; Type: TABLE DATA; Schema: public; Owner: svong01
--



--
-- Data for Name: avoir; Type: TABLE DATA; Schema: public; Owner: svong01
--



--
-- Data for Name: contenir; Type: TABLE DATA; Schema: public; Owner: svong01
--



--
-- Data for Name: cordee; Type: TABLE DATA; Schema: public; Owner: svong01
--



--
-- Data for Name: difficulte; Type: TABLE DATA; Schema: public; Owner: svong01
--



--
-- Data for Name: encadrer; Type: TABLE DATA; Schema: public; Owner: svong01
--



--
-- Data for Name: exercer; Type: TABLE DATA; Schema: public; Owner: svong01
--



--
-- Data for Name: guide; Type: TABLE DATA; Schema: public; Owner: svong01
--



--
-- Data for Name: localite; Type: TABLE DATA; Schema: public; Owner: svong01
--



--
-- Data for Name: pratiquer; Type: TABLE DATA; Schema: public; Owner: svong01
--



--
-- Data for Name: proposer; Type: TABLE DATA; Schema: public; Owner: svong01
--



--
-- Data for Name: sortie; Type: TABLE DATA; Schema: public; Owner: svong01
--



--
-- Name: sortie_nums_seq; Type: SEQUENCE SET; Schema: public; Owner: svong01
--

SELECT pg_catalog.setval('public.sortie_nums_seq', 1, false);


--
-- Data for Name: voie; Type: TABLE DATA; Schema: public; Owner: svong01
--



--
-- Name: voie_idv_seq; Type: SEQUENCE SET; Schema: public; Owner: svong01
--

SELECT pg_catalog.setval('public.voie_idv_seq', 1, false);


--
-- Name: adherent adherent_pkey; Type: CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.adherent
    ADD CONSTRAINT adherent_pkey PRIMARY KEY (emaila);


--
-- Name: appartenir appartenir_pkey; Type: CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.appartenir
    ADD CONSTRAINT appartenir_pkey PRIMARY KEY (emaila, numcordee);


--
-- Name: ascension ascension_pkey; Type: CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.ascension
    ADD CONSTRAINT ascension_pkey PRIMARY KEY (idv, numcordee, dateascension);


--
-- Name: avoir avoir_pkey; Type: CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.avoir
    ADD CONSTRAINT avoir_pkey PRIMARY KEY (idv, notefr);


--
-- Name: contenir contenir_pkey; Type: CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.contenir
    ADD CONSTRAINT contenir_pkey PRIMARY KEY (idv, nums);


--
-- Name: cordee cordee_pkey; Type: CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.cordee
    ADD CONSTRAINT cordee_pkey PRIMARY KEY (numcordee);


--
-- Name: difficulte difficulte_pkey; Type: CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.difficulte
    ADD CONSTRAINT difficulte_pkey PRIMARY KEY (notefr);


--
-- Name: encadrer encadrer_pkey; Type: CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.encadrer
    ADD CONSTRAINT encadrer_pkey PRIMARY KEY (emailg, notefr);


--
-- Name: exercer exercer_pkey; Type: CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.exercer
    ADD CONSTRAINT exercer_pkey PRIMARY KEY (emaila, notefr);


--
-- Name: guide guide_pkey; Type: CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.guide
    ADD CONSTRAINT guide_pkey PRIMARY KEY (emailg);


--
-- Name: localite localite_pkey; Type: CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.localite
    ADD CONSTRAINT localite_pkey PRIMARY KEY (region);


--
-- Name: pratiquer pratiquer_pkey; Type: CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.pratiquer
    ADD CONSTRAINT pratiquer_pkey PRIMARY KEY (emailg, notefr);


--
-- Name: proposer proposer_pkey; Type: CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.proposer
    ADD CONSTRAINT proposer_pkey PRIMARY KEY (emaila, nums);


--
-- Name: sortie sortie_pkey; Type: CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.sortie
    ADD CONSTRAINT sortie_pkey PRIMARY KEY (nums);


--
-- Name: voie voie_pkey; Type: CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.voie
    ADD CONSTRAINT voie_pkey PRIMARY KEY (idv);


--
-- Name: adherent adherent_joindre_sortie_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.adherent
    ADD CONSTRAINT adherent_joindre_sortie_fkey FOREIGN KEY (joindre_sortie) REFERENCES public.sortie(nums);


--
-- Name: appartenir appartenir_emaila_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.appartenir
    ADD CONSTRAINT appartenir_emaila_fkey FOREIGN KEY (emaila) REFERENCES public.adherent(emaila);


--
-- Name: appartenir appartenir_numcordee_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.appartenir
    ADD CONSTRAINT appartenir_numcordee_fkey FOREIGN KEY (numcordee) REFERENCES public.cordee(numcordee);


--
-- Name: ascension ascension_idv_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.ascension
    ADD CONSTRAINT ascension_idv_fkey FOREIGN KEY (idv) REFERENCES public.voie(idv);


--
-- Name: ascension ascension_numcordee_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.ascension
    ADD CONSTRAINT ascension_numcordee_fkey FOREIGN KEY (numcordee) REFERENCES public.cordee(numcordee);


--
-- Name: avoir avoir_idv_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.avoir
    ADD CONSTRAINT avoir_idv_fkey FOREIGN KEY (idv) REFERENCES public.voie(idv);


--
-- Name: avoir avoir_notefr_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.avoir
    ADD CONSTRAINT avoir_notefr_fkey FOREIGN KEY (notefr) REFERENCES public.difficulte(notefr);


--
-- Name: contenir contenir_idv_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.contenir
    ADD CONSTRAINT contenir_idv_fkey FOREIGN KEY (idv) REFERENCES public.voie(idv);


--
-- Name: contenir contenir_nums_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.contenir
    ADD CONSTRAINT contenir_nums_fkey FOREIGN KEY (nums) REFERENCES public.sortie(nums);


--
-- Name: encadrer encadrer_emailg_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.encadrer
    ADD CONSTRAINT encadrer_emailg_fkey FOREIGN KEY (emailg) REFERENCES public.guide(emailg);


--
-- Name: encadrer encadrer_notefr_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.encadrer
    ADD CONSTRAINT encadrer_notefr_fkey FOREIGN KEY (notefr) REFERENCES public.difficulte(notefr);


--
-- Name: exercer exercer_emaila_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.exercer
    ADD CONSTRAINT exercer_emaila_fkey FOREIGN KEY (emaila) REFERENCES public.adherent(emaila);


--
-- Name: exercer exercer_notefr_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.exercer
    ADD CONSTRAINT exercer_notefr_fkey FOREIGN KEY (notefr) REFERENCES public.difficulte(notefr);


--
-- Name: pratiquer pratiquer_emailg_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.pratiquer
    ADD CONSTRAINT pratiquer_emailg_fkey FOREIGN KEY (emailg) REFERENCES public.guide(emailg);


--
-- Name: pratiquer pratiquer_notefr_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.pratiquer
    ADD CONSTRAINT pratiquer_notefr_fkey FOREIGN KEY (notefr) REFERENCES public.difficulte(notefr);


--
-- Name: proposer proposer_emaila_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.proposer
    ADD CONSTRAINT proposer_emaila_fkey FOREIGN KEY (emaila) REFERENCES public.adherent(emaila);


--
-- Name: proposer proposer_nums_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.proposer
    ADD CONSTRAINT proposer_nums_fkey FOREIGN KEY (nums) REFERENCES public.sortie(nums);


--
-- Name: voie voie_est_situe_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.voie
    ADD CONSTRAINT voie_est_situe_fkey FOREIGN KEY (est_situe) REFERENCES public.localite(region);


--
-- Name: voie voie_est_suivi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: svong01
--

ALTER TABLE ONLY public.voie
    ADD CONSTRAINT voie_est_suivi_fkey FOREIGN KEY (est_suivi) REFERENCES public.voie(idv);


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

