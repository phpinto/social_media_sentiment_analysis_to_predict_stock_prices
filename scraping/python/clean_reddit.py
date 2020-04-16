import numpy as np
import pandas as pd
import re

#load data
df = pd.read_csv("reddit_data.csv")

#select just the columns we want to see
df = df[['title', 'selftext', 'num_comments', 'score', 'created_utc', 'subreddit']]

#remve extra whitespaces, Nans, and [removed]/[deleted] from selftext
df = df.replace(np.nan, '', regex=True)
df = df.replace('\[deleted\]', '', regex=True)
df = df.replace('\[removed\]', '', regex=True)
df.selftext = df.selftext.str.strip()
df.title = df.title.str.strip()

#helper function to clean the texts
def clean_text(text):
    cleaned = re.sub('[^a-zA-Z\' ]', '', text)
    cleaned = cleaned.lower()
    return cleaned

df['text'] = df['title'] + " " + df['selftext'] #create single text column

df.text = df.text.apply(clean_text) #clean the text columns

df2 = df.drop(columns = ['selftext', 'title']) #drop redundant columns

df2.to_csv('reddit_text.csv')
