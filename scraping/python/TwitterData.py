import GetOldTweets3 as got
import pandas as pd
from datetime import datetime
import requests
import time
import sys
import urllib
import sys, io
import ssl

try:
    _create_unverified_https_context = ssl._create_unverified_context
except AttributeError:
    # Legacy Python that doesn't verify HTTPS certificates by default
    pass
else:
    # Handle target environment that doesn't support HTTPS verification
    ssl._create_default_https_context = _create_unverified_https_context

#importing dataset
companies = pd.read_csv("companies.csv")
companies = companies.dropna()

print(sys.argv)
start_comp = int(sys.argv[1])
end_comp = int(sys.argv[2])
out_file = sys.argv[3]
print(start_comp,end_comp,out_file)
group_companies = list(companies["Company"][start_comp:end_comp])

def get_twitter_info():
    tweet_df["tweet_text"] = tweet_df["got_criteria"].apply(lambda x: x.text)
    tweet_df["date"] = tweet_df["got_criteria"].apply(lambda x: x.date)
    tweet_df["hashtags"] = tweet_df["got_criteria"].apply(lambda x: x.hashtags)
    tweet_df["retweets"] = tweet_df["got_criteria"].apply(lambda x: x.retweets)
    tweet_df["favorites"] = tweet_df["got_criteria"].apply(lambda x: x.favorites)
    tweet_df["mentions"] = tweet_df["got_criteria"].apply(lambda x: x.mentions)


#function to pass imputs
def inputs(first_date, last_date, number_tweets, comp):
    first = True
    for i in comp:
        start = pd.to_datetime(first_date)
        end = pd.to_datetime(last_date)
        tweet_criteria_1 = []
        while start <= end:
            print(start, i)
            stdout = sys.stdout
            sys.stdout = io.StringIO()
            try:
                #print('trying...')
                tweet_criteria = got.manager.TweetCriteria().setQuerySearch("#"+i)\
                                                .setSince(start.strftime("%Y-%m-%d"))\
                                                .setUntil((start +  pd.DateOffset(days=1)).strftime("%Y-%m-%d"))\
                                                .setMaxTweets(number_tweets)\
                                                .setTopTweets(True)\
                                                .setLang("en")
                #print(tweet_criteria)
                next_day_tweets = got.manager.TweetManager.getTweets(tweet_criteria)
                #print(next_day_tweets)
                tweet_criteria_1 = tweet_criteria_1 + next_day_tweets
            except:
                #print('except...')
                output = sys.stdout.getvalue() 
                sys.stdout = stdout
                if "429" in output:
                    start -= pd.DateOffset(days=1)
                    print("too many requests error")
                    time.sleep(60)
                print(output)
                pass
            sys.stdout = stdout
            start += pd.DateOffset(days=1)
        #print(tweet_criteria_1)
        if first:
            tweet_df = pd.DataFrame({'got_criteria':tweet_criteria_1, 'company':i})
            first = False
        else:
            tweet_df = tweet_df.append(pd.DataFrame({'got_criteria':tweet_criteria_1, "company": i}))
        print(tweet_df)
        print( "{} company done".format(i))
    return tweet_df
    
tweet_df = inputs("2017-01-01", "2020-04-02", 500, group_companies)

get_twitter_info()

tweet_df.to_csv(out_file)

