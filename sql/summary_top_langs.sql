SELECT name, count(uid) AS amount
FROM   user_language 
JOIN   languages
USING  (lid)
GROUP  BY lid
ORDER  BY amount DESC
LIMIT  {nos}
