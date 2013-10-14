SELECT fid, name
FROM   user_framework
JOIN   frameworks
USING  (fid)
WHERE  uid = {uid}
