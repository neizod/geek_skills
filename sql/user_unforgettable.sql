SELECT sid, s.name
FROM   user_skill
JOIN   skills s
USING  (sid)
WHERE  uid = {uid}
AND    sid IN (
    SELECT DISTINCT sid
    FROM   skill_requirement
    WHERE  rid IN (
        SELECT sid
        FROM   user_skill
        WHERE  uid = {uid}
    )
)
