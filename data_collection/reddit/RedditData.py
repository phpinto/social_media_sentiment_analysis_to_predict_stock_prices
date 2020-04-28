import sys
import praw
import numpy as np
import pandas as pd
from datetime import datetime, timezone
import requests
import datetime


#use your own credentials for access to reddit api, specify as system args
my_client_id = sys.argv[1]
my_secret = sys.argv[2]
my_user_agent = sys.argv[3]

#initialize reddit api
reddit = praw.Reddit(client_id=my_client_id, client_secret=my_secret, user_agent=my_user_agent)


#load other data
stock_data = pd.read_csv("../data/stocks/csv/stock_prices.csv")
company_data = pd.read_csv("../data/stocks/csv/companies.csv")
brand_data = pd.read_csv("../data/stocks/csv/brands.csv")


#get array of all subreddit threads to look at
subreddits = np.array([sub for sub in brand_data.subreddit.unique() if str(sub) != 'nan'])

#helper function that gets posts from a given subreddit for a given time period
def get_posts_for_time_period(sub, beginning, end=int(datetime.datetime.now().timestamp())):
    """
    Gets posts from the given subreddit for the given time period
    :param sub: the subreddit to retrieve posts from
    :param beginning: The unix timestamp of when the posts should begin
    :param end: The unix timestamp of when the posts should end (defaults to right now)
    :return:
    """
    url = "https://apiv2.pushshift.io/reddit/submission/search/?subreddit={0}&limit=1000&after={1}&before={2}".format(sub, beginning, end)

    response = requests.get(url)
    resp_json = response.json()
    return resp_json['data']

#helper function to get all posts in a subreddit
def get_all_posts_for_sub(subreddit):
    beginning_timestamp = int(reddit.subreddit(subreddit).created_utc)
    end_timestamp = int(datetime.datetime(year=2020, month=3, day=20).timestamp())
    data = get_posts_for_time_period(subreddit, beginning_timestamp, end_timestamp)
    all_data = data
    i=1
    while len(data) >= 1000:
        i+=1
        # go back for more data
        last_one = data[999]
        beginning_timestamp = last_one['created_utc'] + 1
        data = get_posts_for_time_period(sub=subreddit, beginning=beginning_timestamp, end=end_timestamp)
        all_data.extend(data)
    print("Collected data for {0} with {1} api calls".format(subreddit, i))
    return all_data
    ##Outputs a list of dictionaries


##full procedure:
data = pd.DataFrame(get_all_posts_for_sub(subreddits[0]))
for s in subreddits[1:]:
    data = data.append(pd.DataFrame(get_all_posts_for_sub(s)))

#save the data
data.to_csv("reddit_data.csv")
