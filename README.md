# social_media_sentiment_analysis_to_predict_revenues
Final Project for CSE 6240 - Web Search &amp; Text Mining

The goal of this project is to explore the concept of emotional theory in the stock market by understanding if social media sentiment analysis can be used to predict fluctuations in the stock price of a given company. To do so, we extracted, cleaned and generated sentiment for more than 3 million tweets on 54 companies and 4 million reddits on 30 companies traded in the S&P500.

The github is organized the following way:
* API_calls: 
  * Python - TwitterData.py -> contains the code to extract tweets using GetOldTweets3 python library. The parameters passed include: start and end date (in this case it was fixed from "2017-01-01" to "2020-04-02"), number of tweets to be extracted per hasthag per day (in this case it was fixed at 500) and hasthags to be extracted. The hasthags to be extracted come from a CSV file - "brands.csv" - which is included in the Google drive folder shared below. Because it takes a long time to extract all tweets, we extracted 10 tweets a time and we define the rows to be used as a parameter in the terminal. The command to run in the terminal includes "TwitterData.py brands.csv $first row - last row$ $output name". 

* twitter_code:
  * Creating_cleaned_database.ipynb -> Reads in the final raw dataset with all the tweets extracted
