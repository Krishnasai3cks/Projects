import turtle
import time
import random
delay = 0.12
score = 0
high_score = 0
win = turtle.Screen()
win.title("Snake Game")
win.bgcolor("green")
win.setup(width=600, height=600)
win.tracer(0)

head = turtle.Turtle()
head.speed(0)
head.shape('square')
head.color('orange')
head.penup()
head.goto(0, 0)
head.direction = "stop"
i = 0


def move():
    if head.direction == 'up':
        head.sety(head.ycor()+20)
    if head.direction == 'down':
        head.sety(head.ycor()-20)
    if head.direction == 'left':
        head.setx(head.xcor()-20)
    if head.direction == 'right':
        head.setx(head.xcor()+20)


def up():
    if head.direction != 'down':
        head.direction = 'up'


def down():
    if head.direction != 'up':
        head.direction = 'down'


def left():
    if head.direction != 'right':
        head.direction = 'left'


def right():
    if head.direction != 'left':
        head.direction = 'right'


pen = turtle.Turtle()
pen.penup()
pen.hideturtle()
pen.goto(0, 250)
pen.write("Score: 0 High Score: 0", align="center",
          font=("Courier", 24, "normal"))
food = turtle.Turtle()
food.penup()
food.shape("circle")
food.color('yellow')
food.speed(0)
food.goto(100, 100)

boxes = []

win.listen()
win.onkey(up, "i")
win.onkey(down, 'k')
win.onkey(left, "j")
win.onkey(right, "l")


def end():
    time.sleep(1)
    head.goto(0, 0)
    head.direction = "stop"
    score = 0
    delay = 0.1
    print(score, delay)
    pen.clear()
    for i in boxes:
        i.goto(500, 500)
    boxes.clear()
    pen.write("Score: 0 High Score: {}".format(high_score),
              align="center", font=("Courier", 24, "normal"))


while True:
    win.update()
    if abs(head.xcor()) > 300 or abs(head.ycor()) > 300:
        end()
    if head.distance(food) < 20:
        food.goto(random.randint(-280, 280), random.randint(-280, 280))
        score += 20
        if score > high_score:
            high_score = score
        newbox = turtle.Turtle()
        newbox.shape('square')
        newbox.penup()
        newbox.color('orange')
        boxes.append(newbox)
        pen.clear()
        pen.write("Score: {} High Score: {}".format(score, high_score),
                  align="center", font=("Courier", 24, "normal"))
    for box in range(len(boxes)-1, 0, -1):
        if head.distance(boxes[box]) < 20:
            end()
            break
        boxes[box].goto(boxes[box-1].xcor(), boxes[box-1].ycor())
    if len(boxes) > 0:
        boxes[0].goto(head.xcor(), head.ycor())
    move()
    time.sleep(delay)
win.mainloop()
