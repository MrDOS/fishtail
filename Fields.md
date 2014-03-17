Data definition
===============

Fishtail accepts data sent via HTTP `POST` requests and persists them in
a PostgreSQL database. Submitted data must be JSON-encoded. For some
examples of valid input, see `example.json`.

Structure
---------

Submitted JSON data must be an array of fishing session objects. Each
session provides metadata about the session, and a representation of one
or more fish. Even when sending only one session, it must be wrapped in
an array.

Any properties defined on submitted objects that are not documented
below will be ignored.

### Sessions

Session objects must define the following properties:

* `username`: the TrackMyFish username to be associated with the session
* `startDate`: the start of the session as the number of seconds since
    `1970-01-01 00:00:00`
* `endDate`: the end of the session as the number of seconds since
    `1970-01-01 00:00:00`
* `anglers`: the number of anglers in the area
* `exactAnglers`: whether the number of anglers in the area is exact
* `lines`: the number of fishing lines involved in the session
* `catches`: the total number of fish caught, including unlogged fish
* `exactCatches`: whether the total number of fish caught is exact
* `fish`: an array of objects defining individual fish

The location must also be provided in one of two ways: either by
populating the properties `latitude` and `longitude` with a precise
location, or by populating the property `locationName` with a string
describing the location. Per communication with the biology department,
it is not currently feasible to attach a general pair of latitude/longitude
coordinates with each of the named locations they have provided.

### Fish

The following fields must always be populated for fish:

* `species`: the fish species (see below)
* `length`: the length of the fish in millimetres
* `exactLength`: whether the length of the fish is exact
* `catchHealth`: the condition of the fish upon catch (see below)

If `catchHealth` is a value other than `dead`, the following field must
also be populated:

* `releaseHealth`: the condition of the fish upon release (see below)

A combination of, or all of, the following properties must be defined
based on whether the fish is tagged or not:

* `tagged`: whether the fish is tagged
* `tagId`: the ID on the fish tag
* `tagColor`: the colour of the fish tag (see below)
* `tookSample`: whether a scale sample was taken

These properties are evaluated as follows:

* If `tagged` is true, the values of `tagId` and `tagColor` are forcibly
    used even if their values are unset (in which case `null` is used).
* If `tagged` is false, the values of `tagId` and `tagColor` are ignored.
    If no value has been provided for `tookSample` or it is null, `false`
    is assumed.
* If `tagId` and `tagColor` are both set and neither are `null`, `tagged`
    is implied to be true.
* If either of `tagId` or `tagColor` are not set or either are `null`,
    `tagged` is implied to be false.

The following optional properties may also be defined:

* `photo`: a Base64-encoded JPEG photo of the fish

Values of Enumerated Types
--------------------------

### Health levels

* `dead`
* `weak`
* `healthy`

### Locations

See table in `App Details.docx`.

### Species

* `atlantic sturgeon`
* `atlantic salmon`
* `dogfish`
* `skate`
* `striped bass`

### Tag colours

* `blue`
* `pink`
* `red`
* `yellow`

Green and orange, originally listed in the project overview slide deck,
are not to be included.

Submitting data
===============

Two parameters must be sent to Fishtail in order to successfully store a fishing
session: `session`, containing the JSON-encoded fishing session data, and
`secret`, containing a secret key designated on a per-consumer basis by the
operator of the API endpoint. The `session` data must be `POST`ed; `secret` can
be provided via either `GET` or `POST`.

Response
--------

Responses from the endpoint will be JSON-encoded messages with one or
two properties:

* `success`: a boolean indicating the success of the execution of the request
* `error`: a human-readable error message present only when `success` is `false`
