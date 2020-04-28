import numpy as np
import pandas as pd
import nltk
import warnings
warnings.filterwarnings('ignore')
from nltk.sentiment.vader import SentimentIntensityAnalyzer
nltk.download('vader_lexicon')
analyzer = SentimentIntensityAnalyzer()

my_df = pd.read_csv('reddit_text.csv')
vs_compound = []
vs_pos = []
vs_neu = []
vs_neg = []

#helper function that get the sentiments
def get_sentiment(text):
    scores = analyzer.polarity_scores(text)
    vs_compound.append(scores['compound'])
    vs_pos.append(scores['pos'])
    vs_neu.append(scores['neu'])
    vs_neg.append(scores['neg'])

my_df.text.apply(get_sentiment)

sentiment_data = pd.DataFrame({'compound':vs_compound, 'positive':vs_pos, 'neutral':vs_neu, 'negative':vs_neg})
sentiment_data.to_csv('reddit_sentiment.csv')
sentiment_df = pd.concat([my_df, sentiment_data], axis=1)
sentiment_df.to_csv('reddit_text_sentiment.csv')
