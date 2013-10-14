SELECT lid, name
FROM   user_language
JOIN   languages
USING  (lid)
WHERE  uid = {uid}
