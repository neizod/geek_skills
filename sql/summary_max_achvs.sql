SELECT max(has) AS maximum
FROM   (
    SELECT count(aid) AS has
    FROM   user_achievement
    GROUP  BY uid
) AS   tmp
