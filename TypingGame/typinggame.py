import pygame
import random

pygame.init()

background = (200, 200, 255)
blue = (30, 30, 255)
green = (30, 150, 30)

X = 800
Y = 450
speed = 0.03
point = 0
nowords = 0


def new_word(oldword):
    global chosenWord, pressedWord, word_X, word_Y, text, pointCaption, speed, nowords
    word_X = random.randint(100, 500)
    word_Y = 0
    speed += 0.003
    pressedWord = ""
    lines = open("words.txt").read().splitlines()
    rline = random.choice(lines)
    chosenWord = rline.lower()
    text = font.render(chosenWord, True, blue)


win = pygame.display.set_mode((X, Y))
pygame.display.set_caption("Fast Typing Game")

font = pygame.font.SysFont("ComicSansNS", 32)

new_word('')
while True:
    win.fill(background)
    word_Y += speed

    text1 = font.render('', True, green)
    win.blit(text, (int(word_X), int(word_Y)))
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            pygame.quit()
            quit()
        elif event.type == pygame.KEYDOWN:
            if event.key == pygame.K_ESCAPE:
                pygame.quit()
                quit()
            a = pygame.key.name(event.key)
            pressedWord += a
            font = pygame.font.SysFont("Times new Roman", 32)
            text1 = font.render(a, True, green)
            if chosenWord.startswith(pressedWord):
                if chosenWord == pressedWord:
                    point += len(chosenWord)
                    nowords += 1
                    oldword = pressedWord
                    new_word(oldword)
            else:
                pressedWord = ""
    pointCaption = font.render(str(point), True, green)
    win.blit(pointCaption, (10, 5))

    if word_Y < Y-5:
        pygame.display.update()
    else:
        event = pygame.event.wait()

        if event.type == pygame.KEYDOWN and event.key == pygame.K_SPACE:
            speed = 0.03
            point = 0
            new_word('')
