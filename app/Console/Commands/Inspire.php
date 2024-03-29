<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Inspire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'give me a quote that inspires me!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return $this->comment($this->getQuote());
    }
    
    private function getQuote()
    {
        return collect([
            "Be yourself; everyone else is already taken.",
            "To live is the rarest thing in the world. Most people exist, that is all.",
            "True friends stab you in the front.",
            "Women are made to be Loved, not understood.",
            "Be the change that you wish to see in the world.",
            "Live as if you were to die tomorrow. Learn as if you were to live forever.",
            "No one can make you feel inferior without your consent.",
            "Great minds discuss ideas; average minds discuss events; small minds discuss people.",
            "Do what you feel in your heart to be right - for you'll be criticized anyway.",
            "Do one thing every day that scares you.",
            "Darkness cannot drive out darkness: only light can do that. Hate cannot drive out hate; only love can do that.",
            "Our lives begin to end the day we become silent about things that matter.",
            "In the end, we will remember not the words of our enemies, but the silence of our friends.",
            "Injustice anywhere is a threat to justice everywhere.",
            "The time is always right to do what is right.",
            "Life's most persistent and urgent question is, 'What are you doing for others?",
            "Weak people revenge. Strong people forgive. Intelligent People Ignore.",
            "I have not failed. I've just found 10,000 ways that won't work.",
            "Genius is one percent inspiration and ninety-nine percent perspiration.",
            "Our greatest weakness lies in giving up. The most certain way to succeed is always to try just one more time.",
            "If we did all the things we are capable of, we would literally astound ourselves.",
            "Imagination is more important than knowledge. Knowledge is limited. Imagination encircles the world.",
            "Life isn't about finding yourself. Life is about creating yourself.",
            "Success is not final, failure is not fatal: it is the courage to continue that counts.",
            "If you're going through hell, keep going.",
            "We make a living by what we get, but we make a life by what we give.",
            "Peace begins with a smile.",
            "Spread love everywhere you go. Let no one ever come to you without leaving happier.",
            "If you can't feed a hundred people, then feed just one.",
            "Kind words can be short and easy to speak, but their echoes are truly endless.",
            "Isn't it nice to think that tomorrow is a new day with no mistakes in it yet?",
            "Tomorrow is always fresh, with no mistakes in it.",
            "We should regret our mistakes and learn from them, but never carry them forward into the future with us.",
            "It's so easy to be wicked without knowing it, isn't it?",
            "All the darkness in the world cannot extinguish the light of a single candle.",
            "Start by doing what's necessary; then do what's possible; and suddenly you are doing the impossible.",
            "Preach the Gospel at all times and when necessary use words.",
            "A single sunbeam is enough to drive away many shadows.",
            "You never fail until you stop trying.",
            "You see things; you say, 'Why?' But I dream things that never were; and I say 'Why not?",
            "We don't stop playing because we grow old; we grow old because we stop playing.",
            "Progress is impossible without change, and those who cannot change their minds cannot change anything.",
            "A life spent making mistakes is not only more honorable, but more useful than a life spent doing nothing.",
            "Kindness is a language which the deaf can hear and the blind can see.",
            "The secret of getting ahead is getting started.",
            "Whenever you find yourself on the side of the majority, it is time to pause and reflect.",
            "The two most important days in your life are the day you are born and the day you find out why.",
            "Truth is stranger than fiction, but it is because Fiction is obliged to stick to possibilities; Truth isn't.",
            "If you tell the truth, you don't have to remember anything.",
            "I have never met a man so ignorant that I couldn't learn something from him",
            "Earth provides enough to satisfy every man's needs, but not every man's greed.",
            "Where there is love there is life.",
            "Happiness is when what you think, what you say, and what you do are in harmony.",
            "The weak can never forgive. Forgiveness is the attribute of the strong.",
            "Strength does not come from physical capacity. It comes from an indomitable will.",
            "You must not lose faith in humanity. Humanity is an ocean; if a few drops of the ocean are dirty, the ocean does not become dirty.",
            "In a gentle way, you can shake the world.",
            "He that can have patience can have what he will.",
            "Either write something worth reading or do something worth writing.",
            "Tell me and I forget, teach me and I may remember, involve me and I learn.",
            "Never ruin an apology with an excuse.",
            "Early to bed and early to rise makes a man healthy, wealthy and wise.",
            "By failing to prepare, you are preparing to fail.",
            "Those who look for the bad in people will surely find it.",
            "People don't realize how a man's whole life can be changed by one book.",
            "If you have no critics you'll likely have no success.",
            "I'm for truth, no matter who tells it. I'm for justice, no matter who it's for or against.",
            "It is not a lack of Love, but a lack of People that makes unhappy marriages.",
            "He who has a why to live can bear almost any how.",
            "That which does not kill us makes us stronger",
            "To live is to suffer, to survive is to find some meaning in the suffering.",
            "There is always some madness in love. But there is also always some reason in madness.",
            "No price is too high to pay for the privilege of owning yourself.",
            "You know, when it works, Love is amazing. It's not overrated.",
            "Life is an awful, ugly place to not have a best friend.",
            "There is never a time or place for true love. It happens accidentally, in a heartbeat, in a single flashing, throbbing moment.",
            "Anyone can hide. Facing up to things, working through them, that's what makes you strong.",
            "If you want to live a happy life, tie it to a goal, not to people or things",
            "Your time is limited, so don’t waste it living someone else’s life.",
            "Everything around you that you call life was made up by people, and you can change it.",
            "Design is not just what it looks like and feels like. Design is how it works.",
            "Innovation distinguishes between a leader and a follower.",
            "Sometimes life is going to hit you in the head with a brick. Don't lose faith.",
            "Sometimes when you innovate, you make mistakes. It is best to admit them quickly, and get on with improving your other innovations.",
            "A lot of times, people don't know what they want until you show it to them.",
            "Let’s go invent tomorrow rather than worrying about what happened yesterday.",
            "The most precious thing that we all have with us is time.",
            "You have to trust in something, your gut, destiny, life, karma, whatever.",
            "Every child is an artist, the problem is staying an artist when you grow up.",
            "The purpose of art is washing the dust of daily life off our souls.",
            "Good artists copy, great artists steal.",
            "Art is a lie that makes us realize truth.",
            "Inspiration does exist, but it must find you working.",
            "Strive not to be a success, but rather to be of value.",
            "The pessimist sees difficulty in every opportunity. The optimist sees opportunity in every difficulty.",
            "We learn wisdom from failure much more than from succes.",
            "Hope is like the sun, which, as we journey toward it, casts the shadow of our burden behind us.",
            "We often discover what will do, by finding out what will not do; and probably he who never made a mistake never made a discovery.",
            "Lost wealth may be replaced by industry, lost knowledge by study, lost health by temperance or medicine, but lost time is gone forever.",
            "Life will always be to a large extent what we ourselves make it.",
            "Enthusiasm... the sustaining power of all great action.",
            "People who are crazy enough to think they can change the world, are the ones who do.",
            "The fool doth think he is wise, but the wise man knows himself to be a fool.",
            "There is nothing either good or bad, but thinking makes it so.",
            "You're not to be so blind with patriotism that you can't face reality. Wrong is wrong, no matter who does it or says it.",
            "Hell is empty and all the devils are here.",
            "The course of true Love never did run smooth.",
            "Expectation is the root of all heartache.",
            "Listen to many, speak to a few.",
            "One may smile, and smile, and be a villain.",
            "Any fool can know. The point is to understand.",
            "It is not that I'm so smart. But I stay with the questions much longer.",
            "Build your own dreams, or someone else will hire you to build theirs.",
            "Comfort is the enemy of achievement",
            "You know, you don't have to have money to be a successful businessperson.",
            "I can dream alone and strive alone, but true success always requires the help and support of others.",
            "Success isn’t something that happens overnight: it’s a process.",
            "The more we give, the more we receive. It's important to give back, because the seeds you plant today, you will harvest tomorrow.",
            "Either you run the day, or the day runs you.",
            "Start from wherever you are and with whatever you’ve got.",
            "Without constant activity, the threats of life will soon overwhelm the values",
            "If you don’t like how things are, change it! You’re not a tree.",
            "Success is neither magical nor mysterious. Success is the natural consequence of consistently applying basic fundamentals.",
            "How long should you try? Until.",
            "Focus on making yourself better, not on thinking that you are better.",
            "A true friend is someone you can count on no matter what.",
            "Face your fears and you will be able to conquer them.",
            "If you want to know what people believe, don’t read what they write, don’t ask what they believe, just observe what they do.",
            "I used to think I was indecisive, but now I am not quite sure.",
            "Police arrested two kids yesterday, one was drinking battery acid, the other was eating fireworks. They charged one and let the other one off.",
            "You know, somebody actually complimented me on my driving today. They left a little note on the windscreen, it said 'Parking Fine.'",
            "A lie gets halfway around the world before the truth has a chance to get its pants on.",
            "Knowledge is like underwear. It is useful to have it, but not necessary to show it off.",
            "We are all here on earth to help others; what on earth the others are here for I don't know.",
            "Happiness is having a large, loving, caring, close-knit family in another city.",
            "A professor is someone who talks in someone else's sleep.",
            "Everything is changing. People are taking the comedians seriously and the politicians as a joke.",
            "That’s why they call it the American Dream, because you have to be asleep to believe it.",
            "If you’re too open-minded; your brains may fall out.",
            "If you think nobody cares about you, try missing a couple of payments.",
            "There's a fine line between fishing and just standing on the shore like an idiot.",
            "If at first you don't succeed then skydiving definitely isn't for you.",
            "A lot of people are afraid of heights. Not me, I'm afraid of widths.",
            "What's another word for Thesaurus?",
            "You can't have everything. Where would you put it?",
            "Don’t be so humble – you are not that great.",
            "Whether women are better than men I cannot say - but I can say they are certainly no worse.",
            "The best way to teach your kids about taxes is by eating 30 percent of their ice cream.",
            "You can't soar with the eagles as long as you hang out with the turkeys.",
            "You can change your world by changing your words... Remember, death and life are in the power of the tongue.",
            "Nothing is impossible, the word itself says 'I'm possible'!",
            "As you grow older, you will discover that you have two hands, one for helping yourself, the other for helping others.",
            "I never think of myself as an icon. What is in other people's minds is not in my mind. I just do my thing.",
            "The best thing to hold onto in life is each other.",
            "Be nice to nerds. Chances are you'll end up working for one.",
            "Your most unhappy customers are your greatest source of learning.",
            "Success is a lousy teacher. It seduces smart people into thinking they can't lose.",
            "Life is not fair; get used to it.",
            "If you can't make it good, at least make it look good.",
            "Life is like riding a bicycle. To keep your balance, you must keep moving.",
            "Nearly all men can stand adversity, but if you want to test a man’s character, give him power.",
            "The best way to predict your future is to create it.",
            "I would rather be a little nobody, then to be a evil somebody.",
            "I will prepare and some day my chance will come.",
            "Important principles may, and must, be inflexible.",
            "Tact is the ability to describe others as they see themselves.",
            "You cannot escape the responsibility of tomorrow by evading it today.",
            "Knowing thyself, that is the greatest wisdom.",
            "To be humane, we must ever be ready to pronounce that wise, ingenious and modest statement 'I do not know'.",
            "Two truths cannot contradict one another.",
            "Where the senses fail us, reason must step in.",
            "All truths are easy to understand once they are discovered; the point is to discover them."
        ])
        ->random();
    }
}
