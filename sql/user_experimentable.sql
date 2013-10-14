SELECT fid, name
FROM   frameworks
WHERE  fid NOT IN (
    SELECT fid
    FROM   user_framework
    WHERE  uid = {uid}
)
