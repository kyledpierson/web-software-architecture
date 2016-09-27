class Survey < ActiveRecord::Base

  default_scope -> { order(created_at: :desc) }

  validates :title, presence: true,
                  length: { minimum: 5 }
  validates :question, presence: true,
                  length: { minimum: 10 }

end
