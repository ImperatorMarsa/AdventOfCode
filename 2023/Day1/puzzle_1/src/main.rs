use core::panic;
use std::{
    fs::File,
    io::{self, BufRead},
    path::Path,
};

fn main() {
    if let Ok(lines) = read_lines("input/input.txt") {
        for line in lines {
            if let Ok(raw_calibration_value) = line {
                let mut raw_calibration_value_chars = raw_calibration_value.chars();

                let mut calibration_value = String::new();
                loop {
                    match raw_calibration_value_chars.next() {
                        Some(result) => {
                            let tmp_string = String::from(result);
                            match tmp_string.parse::<u32>() {
                                Ok(_) => calibration_value.push(result),
                                Err(_) => (),
                            };
                        }
                        None => {
                            break;
                        }
                    };
                }
                println!(
                    "calibration_value {} {}",
                    calibration_value, raw_calibration_value
                );
            }
        }
    }
}

fn read_lines<P>(filename: P) -> io::Result<io::Lines<io::BufReader<File>>>
where
    P: AsRef<Path>,
{
    let file = File::open(filename)?;
    Ok(io::BufReader::new(file).lines())
}
