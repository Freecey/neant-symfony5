<?php
namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @var ArticleRepository
     */
    private $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/articles", name="article.index")
     * @return Response
     */

    public function index() : Response
    {
        $allArticles = $this->repository->findCatOther();
        dump($allArticles);
//        $article = new Article();
//        $article->setTitle('Titre of 1st Article')
//            ->setIntro('A little introduction of the 1st article')
//            ->setContent("All I want is to be a monkey of moderate intelligence who wears a suit… that's why I'm transferring to business school! And then the battle's not so bad? Why would I want to know that? Bender! Ship! Stop bickering or I'm going to come back there and change your opinions manually!
//
//Shut up and get to the point! Good news, everyone! I've taught the toaster to feel love! Professor, make a woman out of me. You can see how I lived before I met you. Yeah, I do that with my stupidness.
//
//Fetal stemcells, aren't those controversial? Bender, you risked your life to save me! I meant 'physically'. Look, perhaps you could let me work for a little food? I could clean the floors or paint a fence, or service you sexually?
//
//So I really am important? How I feel when I'm drunk is correct? With a warning label this big, you know they gotta be fun! You can crush me but you can't crush my spirit! You, minion. Lift my arm. AFTER HIM!
//
//You won't have time for sleeping, soldier, not with all the bed making you'll be doing. I don't want to be rescued. Yeah. Give a little credit to our public schools. Stop! Don't shoot fire stick in space canoe! Cause explosive decompression!
//
//Bender?! You stole the atom. Can I use the gun? Is today's hectic lifestyle making you tense and impatient? That's not soon enough! This opera's as lousy as it is brilliant! Your lyrics lack subtlety. You can't just have your characters announce how they feel. That makes me feel angry!
//
//There, now he's trapped in a book I wrote: a crummy world of plot holes and spelling errors! Then we'll go with that data file! Wow! A superpowers drug you can just rub onto your skin? You'd think it would be something you'd have to freebase.
//
//Okay, I like a challenge. That's the ONLY thing about being a slave. Bender, quit destroying the universe! Then we'll go with that data file!
//
//You are the last hope of the universe. Interesting. No, wait, the other thing: tedious. Kids don't turn rotten just from watching TV. No. We're on the top.
//
//Calculon is gonna kill us and it's all everybody else's fault! I am the man with no name, Zapp Brannigan! As an interesting side note, as a head without a body, I envy the dead. This is the worst kind of discrimination: the kind against me!
//
//Five hours? Aw, man! Couldn't you just get me the death penalty? Also Zoidberg. Yes, if you make it look like an electrical fire. When you do things right, people won't be sure you've done anything at all.
//
//Do a flip! We're rescuing ya. You're going to do his laundry? Oh God, what have I done? There, now he's trapped in a book I wrote: a crummy world of plot holes and spelling errors! This is the worst part. The calm before the battle.
//
//A sexy mistake. Oh Leela! You're the only person I could turn to; you're the only person who ever loved me. Yeah, lots of people did. Who said that? SURE you can die! You want to die?!
//
//Why would I want to know that? Fry! Stay back! He's too powerful! For one beautiful night I knew what it was like to be a grandmother. Subjugated, yet honored. Good man. Nixon's pro-war and pro-family.
//
//Stop! Don't shoot fire stick in space canoe! Cause explosive decompression! When the lights go out, it's nobody's business what goes on between two consenting adults. We need rest. The spirit is willing, but the flesh is spongy and bruised.
//
//Oh, how awful. Did he at least die painlessly? …To shreds, you say. Well, how is his wife holding up? …To shreds, you say. We'll need to have a look inside you with this camera. Man, I'm sore all over. I feel like I just went ten rounds with mighty Thor.
//
//This is the worst part. The calm before the battle. The key to victory is discipline, and that means a well made bed. You will practice until you can make your bed in your sleep. Oh, I don't have time for this. I have to go and buy a single piece of fruit with a coupon and then return it, making people wait behind me while I complain.
//
//When the lights go out, it's nobody's business what goes on between two consenting adults. I'm just glad my fat, ugly mama isn't alive to see this day. Yes, except the Dave Matthews Band doesn't rock. No. We're on the top.
//
//It's okay, Bender. I like cooking too. We don't have a brig. Well, let's just dump it in the sewer and say we delivered it. Oh dear! She's stuck in an infinite loop, and he's an idiot! Well, that's love for you.
//
//Is today's hectic lifestyle making you tense and impatient? It's toe-tappingly tragic! I'm Santa Claus! No! The kind with looting and maybe starting a few fires! Anyone who laughs is a communist! I don't 'need' to drink. I can quit anytime I want!")
//            ->setAuthor('Cey')
//            ->setCategory('1');
//        $am = $this->getDoctrine()->getManager();
//        $am->persist($article);
//        $am->flush();
        return $this->render('article/index.html.twig', [
            'current_menu' => 'articles'
        ]);
    }

    /**
     * @Route("/articles/{id}-{slug}", name="article.show", requirements={"slug": "[a-z0-9\-]*" })
     * @return Response
     */
    public function show(Article $article,string $slug): Response
    {
        if ($article->getSlug() !== $slug){
            return $this->redirectToRoute('article.show', [
                'id' => $article->getId(),
                'slug' => $article->getSlug()
            ], 301);
        }
        return $this->render('article/show.html.twig',[
            'article' => $article,
            'current_menu' => 'articles'
        ]);
    }

}