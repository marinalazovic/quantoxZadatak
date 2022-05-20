#quantoxZadatak

*running the program: composer seed
                      composer start-dev

*REST API:
-GET http://localhost:3000/api/group/ => return all groups (PHP_URL_QUERY (all optional and in any order)
                                                            ?limit=_&page=_&sort=_&order=_)

-GET http://localhost:3000/api/group/{id} => return a group with id

-POST http://localhost:3000/api/group/ => create a new group (Body/raw(JSON): { "group_name": ""})

-PUT http://localhost:3000/api/group/{id} => update group (Body/raw(JSON): { "group_name": ""})

-DELETE http://localhost:3000/api/group/{id} => delete a group with id


-GET http://localhost:3000/api/mentor/ => return all mentors (PHP_URL_QUERY (all optional and in any order)
                                                              ?limit=_&page=_&sort=_&order=_)

-GET http://localhost:3000/api/mentor/{id} => return a mentor with id

-POST http://localhost:3000/api/mentor/ => create a new mentor (Body/raw(JSON): { "first_name": "" , "last_name": "" , "years_of_experience" : "" , "group_id" : ""})

-PUT http://localhost:3000/api/mentor/{id} => update mentor (Body/raw(JSON): { "first_name": "" , "last_name": "" , "years_of_experience" : "" , "group_id" : ""})

-DELETE http://localhost:3000/api/mentor/{id} => delete a mentor with id


-GET http://localhost:3000/api/intern/ => return all interns (PHP_URL_QUERY (all optional and in any order):
                                                             ?limit=_&page=_&sort=_&order=_)

-GET http://localhost:3000/api/intern/{id} => return a intern with id

-POST http://localhost:3000/api/intern/ => create a new intern (Body/raw(JSON): { "first_name": "" , "last_name": "", "group_id" : "" })

-PUT http://localhost:3000/api/intern/{id} => update intern (Body/raw(JSON): { "first_name": "" , "last_name": "" , "group_id" : ""})

-DELETE http://localhost:3000/api/intern/{id} => delete a intern with id


-POST http://localhost:3000/api/mentor/{id}/intern/{id}/comment => create a new comment (Body/raw(JSON): { "text": "" })

-DELETE http://localhost:3000/api/mentor/{id}/intern/{id}/comment/{id} => delete a comment



