SELECT avg(ea) AS average
FROM   (
    SELECT u.uid, count(fid) AS ea
    FROM   users u
    LEFT   JOIN user_framework uf
    ON     u.uid = uf.uid
    GROUP  BY uid
) AS   tmp
