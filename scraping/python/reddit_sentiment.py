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
for i in range(0, len(my_df['text'])):
    vs_compound.append(analyzer.polarity_scores(my_df['text'][i])['compound'])
        vs_pos.append(analyzer.polarity_scores(my_df['text'][i])['pos'])
	    vs_neu.append(analyzer.polarity_scores(my_df['text'][i])['neu'])
	        vs_neg.append(analyzer.polarity_scores(my_df['text'][i])['neg'])
		sentiment_data = pd.DataFrame({'compound':vs_compound, 'positive':vs_pos, 'neutral':vs_neu, 'negative':vs_neg})
		sentiment_data.to_csv('reddit_sentiment.csv')
		sentiment_df = pd.concat([data, sentiment_data], axis=1)
		sentiment_df.to_csv('reddit_text_sentiment.csv')
