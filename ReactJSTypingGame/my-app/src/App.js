import React from "react";
import { Alert } from "react-alert";
import { render } from "react-dom";
import "./App.css";
import { sentenceList } from "./sentences.js";
var senlislen = sentenceList().length;

let sentence = sentenceList()[Math.floor(Math.random() * senlislen)];
// let sentence = "happy";
const keyspressed = {
  control: false,
  backspace: false,
}; // These are required to support the feature of ctrl+backspace
export default class App extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      userInput: "",
      index: 0,
      timethen: new Date(),
      errorcount: 0,
      firstpara: <span>{sentence}</span>,
      secondpara: <span style={{ color: "green" }}>{}</span>,
      wpm: 0,
    };
    this.handleChange = this.handleChange.bind(this);
    this.onKeyDown = this.onKeyDown.bind(this);
    this.onKeyUp = this.onKeyUp.bind(this);
  }

  onKeyDown(key) {
    // This function is used only when we click backspace
    this.KeyDownMethod(key);
    // You can find this method at the bottom
  }
  onKeyUp(key) {
    this.keyUpMethod(key);
  }
  handleChange(event) {
    // the starting timer to calculate the words per minute
    if (event.target.value.length === 1) {
      this.setState({
        timethen: new Date(),
      });
    }
    if (this.state.errorcount > 0) {
      this.handleTooManyErrors();
    }
    var sentenceChar = sentence[this.state.index];
    var inputChar = event.target.value.charAt(event.target.value.length - 1);
    if (sentenceChar === inputChar) {
      // We have typed a valid character
      this.changeStateWhenCorrect(event); // You can find this method Just below handleChange
      var timenow = new Date();
      this.setState({
        wpm: Math.floor(
          (event.target.value.length / 5) *
            (60 / ((timenow - this.state.timethen) / 1000))
        ),
      });
    } else {
      // We have made a typing mistake // In this condition we have to count the no of errors.
      this.setState({
        userInput: event.target.value,
        index: this.state.index + 1,
        errorcount: this.state.errorcount + 1,
      });
    }
  }
  handleTooManyErrors() {
    var element = document.getElementById("inputBox");
    element.setAttribute("class", "errorclass");
  }
  changeStateWhenCorrect(event) {
    var element = document.getElementById("inputBox");
    element.removeAttribute("class", "errorclass");
    this.setState({
      userInput: event.target.value,
      index: this.state.index + 1,
      firstpara: (
        <span style={{ color: "green" }}>
          {sentence.slice(0, this.state.index)}
          <span style={{ textDecoration: "underline" }}>
            {sentence[this.state.index]}
          </span>
        </span>
      ),
      secondpara: <span>{sentence.slice(this.state.index + 1)}</span>,
    });
  }
  keyUpMethod(key) {
    if (key.keyCode === 8) keyspressed.backspace = false;
    if (key.keyCode === 17) keyspressed.control = false;
  }
  KeyDownMethod(key) {
    if (key.keyCode === 8) keyspressed.backspace = true;
    // to support control + backspace feature
    if (key.keyCode === 17) keyspressed.control = true;
    if (keyspressed.control && keyspressed.backspace) {
      var inputarr = this.state.userInput.split(" ");
      var newIndex =
        this.state.index - inputarr[inputarr.length - 1].length - 1;
      console.log(
        inputarr,
        this.state.index - inputarr[inputarr.length - 1].length
      );
      this.setState({
        userInput: this.state.userInput,
        index: newIndex,
        firstpara: (
          <span style={{ color: "green" }}>{sentence.slice(0, newIndex)}</span>
        ),
        secondpara: <span>{sentence.slice(newIndex)}</span>,
      });
    } else if (key.keyCode === 8) {
      this.setState({
        userInput: this.state.userInput,
        index: this.state.index - 2,
      });
    }
  }
  render() {
    return (
      <div id="container">
        <div className="paragraph">
          {this.state.firstpara}
          {this.state.secondpara}
        </div>
        <input
          type="text"
          id="inputBox"
          value={this.state.userInput}
          onChange={this.handleChange}
          onKeyDown={this.onKeyDown}
          onKeyUp={this.onKeyUp}
          style={{ height: 50, fontSize: 30, fontWeight: "bold" }}
        />
        <div>WPM:{this.state.wpm}</div>
      </div>
    );
  }
}
