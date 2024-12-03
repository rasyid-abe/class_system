
const toolbarOptions = [
    ["bold", "italic", "underline", "strike"], // toggled buttons
    [{ align: [] }],
    ["link", "image", "formula"],
  
  //   [{ header: 1 }, { header: 2 }], // custom button values
    [{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
    [{ script: "sub" }, { script: "super" }], // superscript/subscript
    [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
  //   [{ direction: "rtl" }], // text direction
  
  //   [{ size: ["small", false, "large", "huge"] }], // custom dropdown
    [{ header: [1, 2, 3, 4, 5, 6, false] }],
  
    [{ color: [] }, { background: [] }], // dropdown with defaults from theme
  //   [{ font: [] }],
    ["clean", "code-block"], // remove formatting button
  ];
  
  var quill = new Quill("#quilleditor_question", {
    modules: {
      toolbar: toolbarOptions
    },
    placeholder: "Type your text here...",
    theme: "snow", // or 'bubble'
  });
  var quill = new Quill("#quilleditor", {
    modules: {
      toolbar: toolbarOptions
    },
    placeholder: "Type your text here...",
    theme: "snow", // or 'bubble'
  });