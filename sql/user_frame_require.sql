SELECT fid, languages.name AS name
FROM   frameworks
JOIN   languages
USING  (lid)
WHERE  lid NOT IN (
    SELECT lid
    FROM   user_language
    WHERE  uid = {uid}
)
