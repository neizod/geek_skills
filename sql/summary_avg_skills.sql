SELECT avg(ea) AS average
FROM   (
    SELECT u.uid, count(sid) AS ea
    FROM   users u
    LEFT   JOIN user_skill us
    ON     u.uid = us.uid
    GROUP  BY uid
) AS   tmp
