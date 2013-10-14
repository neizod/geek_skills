SELECT count(distinct uid) AS number
FROM   user_skill u
WHERE  NOT EXISTS (
    SELECT sid
    FROM   skills s
    WHERE  NOT EXISTS (
        SELECT *
        FROM   user_skill us
        WHERE  u.uid = us.uid
        AND    s.sid = us.sid
    )
)
