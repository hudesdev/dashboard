<template>
    <tile :position="position">
        <ul class="grid" style="grid-auto-rows: auto;">
            <li class="overflow-hidden pb-4 mb-4 border-b-2 border-screen" v-for="(tweet, index) in onDisplay" :key="index">
                <div class="markup grid gap-padding" style="grid-auto-rows: auto">
                    <div class="grid gap-2 items-center w-full" style="grid-template-columns: auto 1fr">
                        <avatar :src="tweet.authorAvatar" />
                        <div class="leading-tight min-w-0">
                            <h2 class="truncate" v-html="tweet.authorName"></h2>
                            <div class="truncate text-sm" v-html="tweet.authorScreenName"></div>
                        </div>
                    </div>
                    <div>
                        <div :class="tweet.displayClass" v-html="tweet.html"></div>
                        <div class="mt-1 text-xs text-dimmed inline-flex items-center justify-between w-full">
                            <span v-if="tweet.hasQuote || tweet.isReply"> In reply to {{ tweet.repliedUser }} </span>
                            <relative-date :moment="tweet.date"></relative-date>
                        </div>
                    </div>
                    <img v-if="tweet.image" class="max-h-48 mx-auto" style="objection-fit: cover;" :src="tweet.image" />
                    <div
                        v-if="tweet.hasQuote"
                        class="py-2 pl-2 pr-2 text-xs text-default border-l-2 border-screen bg-accent rounded-r" style="border-left-radius: 10px;border-left-color:white;"
                        v-html="tweet.quote.html"
                    ></div>
                </div>
            </li>
        </ul>
    </tile>
</template>

<script>
import echo from '../mixins/echo';
import Avatar from './atoms/Avatar';
import Tile from './atoms/Tile';
import RelativeDate from './atoms/RelativeDate';
import Tweet from '../services/twitter/Tweet';
import moment from 'moment';
import { diffInSeconds } from '../helpers';
import uniqBy from 'lodash/uniqBy';

export default {
    components: {
        Avatar,
        Tile,
        RelativeDate,
    },

    mixins: [echo],

    props: ['position', 'initialTweets'],

    data() {
        return {
            displayingTopTweetSince: moment(),
            tweets: [],
            waitingLine: [],
            ownScreenNames: ['@m1guelpf', '@sitesauce'],
        };
    },

    created() {
        this.tweets = this.initialTweets.map(tweetProperties => new Tweet(tweetProperties));

        setInterval(this.processWaitingLine, 1000);
    },

    methods: {
        getEventHandlers() {
            return {
                'Twitter.Mentioned': response => {
                    this.addToWaitingLine(new Tweet(response.tweetProperties));
                },
            };
        },

        addToWaitingLine(tweet) {
            this.waitingLine.push(tweet);
        },

        processWaitingLine() {
            if (this.waitingLine.length === 0) {
                return;
            }

            if (diffInSeconds(this.displayingTopTweetSince) < 5) {
                return;
            }

            this.tweets.unshift(this.waitingLine.shift());

            this.tweets = this.tweets.slice(0, 20);

            this.displayingTopTweetSince = moment();
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'twitter',
            };
        },
    },

    computed: {
        onDisplay() {
            let filteredTweets = this.tweets.filter(tweet => {
                return !this.ownScreenNames.includes(tweet.authorScreenName) && !tweet.isRetweet;
            });

            return uniqBy(filteredTweets, (tweet) => {
                return tweet.tweetProperties.id;
            });
        },
    },
};
</script>
