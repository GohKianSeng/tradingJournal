SET @UserGUID = 1;
SET @StartDate = STR_TO_DATE('2018-01-11', '%Y-%m-%d');
SET @EndDate = STR_TO_DATE('2019-01-11', '%Y-%m-%d');
/*total profit trade*/
CREATE TEMPORARY TABLE IF NOT EXISTS temp_ProfitTrade AS(
SELECT COUNT(1) AS TotalProfitTrade, SUM(ABS(ProfitLoss)) AS ProfitLoss, CAST(EntryDateTime AS DATE) AS "Date" FROM tb_Trades WHERE UserGUID = @UserGUID AND (CAST(EntryDateTime AS DATE) BETWEEN @StartDate AND @EndDate) AND TradeType = 'Real' AND ((OrderType = 'Sell' AND EntryPrice >= ExitPrice) OR (OrderType = 'Buy' AND EntryPrice <= ExitPrice))
GROUP BY CAST(EntryDateTime AS DATE));

/*total loss trade*/
CREATE TEMPORARY TABLE IF NOT EXISTS temp_LossTrade AS(
SELECT COUNT(1) AS TotalLossTrade, SUM(ABS(ProfitLoss)) AS ProfitLoss, CAST(EntryDateTime AS DATE) AS "Date" FROM tb_Trades WHERE UserGUID = @UserGUID AND (CAST(EntryDateTime AS DATE) BETWEEN @StartDate AND @EndDate) AND TradeType = 'Real' AND ((OrderType = 'Buy' AND EntryPrice >= ExitPrice) OR (OrderType = 'Sell' AND EntryPrice <= ExitPrice)) 
GROUP BY CAST(EntryDateTime AS DATE));

/*total Missed trade*/
CREATE TEMPORARY TABLE IF NOT EXISTS temp_MissedTrade AS(
SELECT COUNT(1) AS TotalMissedTrade, 0 AS ProfitLoss, CAST(EntryDateTime AS DATE) AS "Date" FROM tb_Trades WHERE UserGUID = @UserGUID AND (CAST(EntryDateTime AS DATE) BETWEEN @StartDate AND @EndDate) AND TradeType = 'Missed'
GROUP BY CAST(EntryDateTime AS DATE));



CREATE TEMPORARY TABLE IF NOT EXISTS temp_ProfitLoss1 AS(
SELECT IFNULL(A.ProfitLoss,0) - IFNULL(B.ProfitLoss,0) AS "DailyGross", A.Date FROM temp_ProfitTrade AS A 
LEFT OUTER JOIN temp_LossTrade AS B ON A.Date = B.Date
ORDER BY A.Date ASC);

CREATE TEMPORARY TABLE IF NOT EXISTS temp_ProfitLoss2 AS(SELECT * FROM temp_ProfitLoss1);

SELECT A.Date, (SELECT SUM(DailyGross) FROM temp_ProfitLoss1 AS B WHERE B.Date <= A.Date) FROM temp_ProfitLoss2 AS A ORDER BY A.Date DESC Limit 100;

SELECT * FROM temp_ProfitLoss1 Order by Date Desc Limit 100;
SELECT * FROM temp_ProfitTrade;
SELECT * FROM temp_LossTrade;
SELECT * FROM temp_MissedTrade;

DROP TABLE temp_ProfitLoss2;
DROP TABLE temp_ProfitLoss1;
DROP TABLE temp_MissedTrade;
DROP TABLE temp_LossTrade;
DROP TABLE temp_ProfitTrade;