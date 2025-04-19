
const BTech = [
    {
        branch: "CSE",
        regulations: [
            {
                regulation: "R20",
                semesters: [
                    {
                        semester: 1,
                        subjects: [
                            "1. Mathematics I",
                            "2. Physics I",
                            "3. Chemistry",
                            "4. Computer Programming",
                            "5. Engineering Mechanics",
                            "6. Electrical Engineering",
                            "7. Environmental Studies",
                            "8. Engineering Drawing",
                            "9. Communication Skills",
                            "10. Physical Education"
                        ]
                    }
                ]
            }
        ]
    }
];
function getData(){
    const course = document.getElementById("s-course");
    const branch = document.getElementById("s-branch");
    const reg = document.getElementById("s-reg");
    const sem = document.getElementById("s-sem");

    console.log(course); // Should log the element, not null
    console.log(branch);
    console.log(reg);
    console.log(sem);

    const subjects = BTech.find(b => b.branch === "CSE")
        .regulations.find(r => r.regulation === "R20")
        .semesters.find(s => s.semester === 1)
        .subjects;

    console.log(subjects);
}