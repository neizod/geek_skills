SELECT name, description
FROM   user_achievement
JOIN   achievements
USING  (aid)
WHERE  uid = {uid}
