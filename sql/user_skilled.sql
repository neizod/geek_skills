SELECT us.sid, s.name
FROM   user_skill us
JOIN   skills s
USING  (sid)
WHERE  us.uid = {uid}
