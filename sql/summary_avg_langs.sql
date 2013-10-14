SELECT avg(ea) AS average
FROM   (
    SELECT u.uid, count(lid) AS ea
    FROM   users u
    LEFT   JOIN user_language ul
    ON     u.uid = ul.uid
    GROUP  BY uid
) AS   tmp
