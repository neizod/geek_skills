SELECT name, more
FROM   user_achievement
JOIN   achievements
USING  (aid)
WHERE  uid = {uid}
