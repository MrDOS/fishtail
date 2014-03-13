Session
-------

* Start/end date (date/time)
* Location (lat/long as `double`, enum) - lat/long populated when explicitly selected; lat/long and enum populated when enum selected
* Number of anglers in area (`int`)
* ...is exact (`bool`)
* Number of lines (`int`)
* Number of fish caught (`int`)
* ...is exact (`bool`)

Fish
----

* Species (enum)
* Length in millimetres (`int`)
* ...is exact (`bool`)
* Condition (enum)
* Is tagged (`bool`)
* Tag colour (enum)
* Tag ID (`string`)
* Took scale sample (`bool`)
* Photo (`blob`)