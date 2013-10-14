SELECT name, count(uid) AS amount
FROM   user_skill
JOIN   skills
USING  (sid)
GROUP  BY sid
ORDER  BY amount DESC
LIMIT  {nos}
