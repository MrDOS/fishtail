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
    session_id      BIGSERIAL PRIMARY KEY,
    username        VARCHAR(50),    /* What's my name again? */
    start_time      TIMESTAMP NOT NULL,
    end_time        TIMESTAMP NOT NULL,
    /* can convert to timestamp:
        select timestamptz 'epoch' + 953559481 * interval '1 second'; */
    location        VARCHAR(50),    /* I dunno... who's driving this thing? */
    latitude        DOUBLE PRECISION,
    longitude       DOUBLE PRECISION,
    anglers         INTEGER NOT NULL,
    exact_anglers   BOOLEAN NOT NULL,
    lines           INTEGER NOT NULL,
    catches         INTEGER NOT NULL,
    exact_catches   BOOLEAN NOT NULL);

CREATE TABLE fish (
    fish_id         BIGSERIAL PRIMARY KEY,
    species         species NOT NULL,
    length          INTEGER NOT NULL,
    exact_length    BOOLEAN NOT NULL,
    catch_health    health NOT NULL,
    release_health  health NOT NULL,
    tagged          BOOLEAN NOT NULL,
    tag_id          VARCHAR(50),    /* We're all going to die! */
    tag_color       colour,
    took_sample     BOOLEAN NOT NULL,
    photo           VARBIT);