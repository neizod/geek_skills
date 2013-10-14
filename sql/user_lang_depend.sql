SELECT lid, name
FROM   user_language
JOIN   frameworks
USING  (lid)
JOIN   user_framework
USING  (fid, uid)
WHERE  uid = {uid}
GROUP  BY lid
