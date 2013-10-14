SELECT lid, name
FROM   languages
WHERE  lid NOT IN (
    SELECT lid
    FROM   user_language
    WHERE  uid = {uid}
)
