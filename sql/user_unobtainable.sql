SELECT DISTINCT s.sid, s.name
FROM   skills s
JOIN   skill_requirement sr
ON     sr.rid = s.sid
WHERE  sr.sid NOT IN (
    SELECT us.sid
    FROM   user_skill us
    WHERE  us.uid = {uid}
)
