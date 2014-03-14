DROP DATABASE IF EXISTS trackmyfish;
CREATE DATABASE trackmyfish;
\c trackmyfish;
CREATE TYPE health AS ENUM ('dead', 'weak', 'healthy');
CREATE TYPE species as ENUM (
    'atlantic sturgeon',
    'atlantic salmon',
    'dogfish',
    'skate',
    'striped bass');
CREATE TYPE colour AS ENUM ('blue', 'pink', 'red', 'yellow');

CREATE TABLE session (
    session_id    BIGSERIAL PRIMARY KEY,
    /* should we add username? */
    start_time    TIMESTAMP NOT NULL,
    end_time      TIMESTAMP NOT NULL,
    /* can convert to timestamp:
         select timestamptz 'epoch' + 953559481 * interval '1 second'; */
    location      VARCHAR(50),       /* I dunno... who's driving this thing? */
    latitude      DOUBLE PRECISION,
    longitude     DOUBLE PRECISION,
    anglers       INTEGER NOT NULL,
    exactAnglers  BOOLEAN NOT NULL,
    lines         INTEGER NOT NULL,
    catches       INTEGER NOT NULL,
    exactCatches  BOOLEAN NOT NULL);

CREATE TABLE fish (
    fish_id       BIGSERIAL PRIMARY KEY,
    species       species NOT NULL,
    length        INTEGER NOT NULL,
    exactLength   BOOLEAN NOT NULL,
    catchHealth   health NOT NULL,
    releaseHealth health NOT NULL,
    tagged        BOOLEAN NOT NULL,
    tagId         VARCHAR(50),        /* We're all going to die! */
    tagColor      colour,
    tookSample    BOOLEAN NOT NULL,
    photo         VARBIT);
