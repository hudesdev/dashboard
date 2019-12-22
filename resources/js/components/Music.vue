<template>
    <tile :position="position" modifiers="transparent">
        <section class="grid gap-padding h-full markup">
            <div class="absolute pin-t w-full h-1 escape-padding block" style="background:red;transition:width 1s ease;" :style="{ width: progress + '%' }" />
            <div class="overflow-hidden z-20 flex items-center justify-center w-full h-full" v-if="currentlyPlaying">
                <div class="h-full w-1/4 rounded overflow-hidden" style="margin:calc(2 * var(--tile-padding));"><img :src="cover" class="w-full" /></div>
                <div>
                    <h1 style="font-size: 1.125rem;" v-text="artist" />
                    <h2 style="font-size: 1.25rem;" v-text="trackName"/>
                </div>
            </div>
            <div class="absolute opacity-25 bg-center bg-cover pin escape-padding" v-if="currentlyPlaying" :style="{ backgroundImage: `url(${cover})`, filter: 'blur(25px)' }"></div>
        </section>
        <div class="absolute pin w-full h-full bg-center bg-no-repeat opacity-25" v-if="!currentlyPlaying" style="background-image: url('/images/svg/music.svg');background-size: calc(5vh + 5vw);"></div>
    </tile>
</template>

<script>
import SpotifyWebApi from 'spotify-web-api-js'
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';
export default {
    components: {
        Tile,
    },
    mixins: [echo, saveState],
    props: ['position'],
    data() {
        return {
            spotify: null,
            artist: '',
            trackName: '',
            artwork: '',
            progress: 0,
        };
    },
    mounted() {
        this.spotify = new SpotifyWebApi()

        this.spotify.setAccessToken(window.dashboard.spotifyToken)

        this.updateSong()
        setInterval(this.updateSong, 1000)
    },
    computed: {
        currentlyPlaying() {
            return !!this.artist;
        },
        hasCover() {
            return !!this.artwork;
        },
        cover() {
            return this.artwork || '/images/music__cover.jpg';
        },
    },
    methods: {
        updateSong() {
            this.spotify.getMyCurrentPlayingTrack().then(track => {
                this.trackName = track.item.name
                this.artist = track.item.artists[0].name
                this.artwork = track.item.album.images[0].url
                this.progress = Math.floor(track.progress_ms / track.item.duration_ms * 100)
            })
        },
        getEventHandlers() {
            return {
                'Spotify.NewToken': response => {
                    this.spotify.setAccessToken(response.token)
                },
            };
        },
        getSaveStateConfig() {
            return {
                cacheKey: 'music',
            };
        },
    },
};
</script>
